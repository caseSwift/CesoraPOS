<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Table;
use App\Models\ArticleOrder;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function store(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        $order = new Order();
        $order->fk_table_id = $table->id;
        $order->total = $request->input('total');
        // add other fields as needed
        $order->save();

        // redirect to the table view
        return redirect()->route('table.show', ['id' => $table->id]);
    }
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
}
