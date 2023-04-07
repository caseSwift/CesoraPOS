<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Table;
use App\Models\ArticleOrder;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class OrderController extends Controller
{
//    public function store(Request $request, $id)
//    {
//        $table = Table::findOrFail($id);
//
//        $order = new Order();
//        $order->fk_table_id = $table->id;
//        $order->total = $request->input('total');
//        // add other fields as needed
//        $order->save();
//
//        // redirect to the table view
//        return redirect()->route('table.show', ['id' => $table->id]);
//    }
    public function placeOrder($tableId, Request $request)
    {
        // validate form data
        $validatedData = $request->validate([
            'articles.*.id' => 'required|exists:articles,id',
            'articles.*.quantity' => 'required|integer|min:1',
        ]);

        // create new order
        $order = new Order();
        $order->fk_table_id = $tableId;
        $order->user_id = Auth::user()->id;
        $order->receipt_id = null; // will be set when the order is finalized
        $order->finalized_at = null; // will be set when the order is finalized
        $order->save();

        // create new article_order entries
        foreach ($validatedData['articles'] as $articleData) {
            $articleOrder = new ArticleOrder();
            $articleOrder->order_id = $order->id;
            $articleOrder->article_id = $articleData['id'];
            $articleOrder->quantity = $articleData['quantity'];
            $articleOrder->save();
        }

        // redirect user back to table view or show success message
        return redirect()->route('table.show', $tableId)->with('success', 'Order placed successfully!');
    }
    public function checkActiveOrder(Request $request)
    {
        $tableId = $request->input('table_id');

        $activeOrder = Order::where('fk_table_id', $tableId)
            ->whereNull('finalized_at')
            ->whereNull('voided_at')
            ->first();

        if ($activeOrder) {
            $orderId = $activeOrder->order_id;
            $orderItem = new ArticleOrder();
            $orderItem->article_name = $request->input('article_name');
            $orderItem->quantity = $request->input('quantity');
            $orderItem->price = $request->input('price');
            $orderItem->fk_order_id = $activeOrder->order_id; // Set the new order ID here
            $orderItem->item_number = $request->input('item_number');
            $orderItem->save();
            return response()->json(['orderId' => $orderId]);
        } else{
            $newOrder = new Order();
            $newOrder->fk_table_id = $tableId;
            $newOrder->save();

            $orderItem = new ArticleOrder();
            $orderItem->article_name = $request->input('article_name');
            $orderItem->quantity = $request->input('quantity');
            $orderItem->price = $request->input('price');
            $orderItem->fk_order_id = $newOrder->order_id; // Set the new order ID here
            $orderItem->save();
            return response()->json(['orderId' => $newOrder->order_id]);
        }

    }

    public function storeOrderItem(Request $request)
    {
        $orderItem = new ArticleOrder();
        $orderItem->article_name = $request->input('article_name');
        $orderItem->quantity = $request->input('quantity');
        $orderItem->price = $request->input('price');
        $orderItem->fk_order_id = $request->input('order_id');
        $orderItem->save();

        return response()->json([
            'orderId' => $orderItem->fk_order_id,
            'orderItemId' => $orderItem->fk_order_id,
        ]);
    }
    public function store(Request $request)
    {
        $order = $request->json()->all();

        // ...

        // create a new order in the database
        $orderModel = new Order();
        $orderModel->fill($order);
        $orderModel->save();

        return response()->json(['orderId' => $orderModel->id]);
    }
    public function newOrder(){
        $newOrder = new Order();
        $newOrder->fk_table_id = 1;
        $newOrder->save();

    }

    public function getActiveItems(Request $request)
    {
        $tableId = $request->input('table_id');

        $activeOrder = Order::where('fk_table_id', $tableId)
            ->whereNull('finalized_at')
            ->whereNull('voided_at')
            ->first();

        if (!$activeOrder) {
            return response()->json([]);
        }

        $activeOrderItems = $activeOrder->articleOrders()
            ->select('item_number','article_name', DB::raw('SUM(quantity) as quantity'), DB::raw('SUM(price * quantity) as total_price'))
            ->groupBy('item_number','article_name')
            ->get();

        return response()->json($activeOrderItems);

    }

    public function checkout($id)
    {
        $table = Table::findOrFail($id);
        $order = $table->orders()->whereNull('finalized_at')->first();

        if ($order) {
            $order->finalized_at = Carbon::now();
            $order->save();

            $totalPrice = ArticleOrder::where('fk_order_id', $order->order_id)->sum('price');

            return response()->json([
                'success' => true,
                'total_price' => $totalPrice
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function getDailyProfit()
    {
        $start = Carbon::now()->subHours(20); // Set the start time to 4am 24 hours ago
        $end = Carbon::now()->addHours(4); // Set the end time to 4am today

        $orders = DB::table('order')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $total = 0;
        foreach ($orders as $order) {
            $totalPrice = ArticleOrder::where('fk_order_id', $order->order_id)->sum('price');
            $total += $totalPrice;
        }

        return response()->json(['total' => $total]);
    }
}
