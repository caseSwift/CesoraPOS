<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoidOrdersController extends Controller
{
    public function index()
    {
        $users = User::whereHas('orders', function ($query) {
            $query->where('finalized', false);
        })->get();

        return view('void-orders', compact('users'));
    }

    public function show(Request $request)
    {
        $userId = $request->input('user_id');

        $orders = Order::where('user_id', $userId)
            ->where('finalized', false)
            ->get();

        $user = User::find($userId);

        return view('void-orders', compact('orders', 'user'));
    }

    public function voidOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back();
    }
    public function showVoidOrdersForm()
    {
        $users = User::all();
        $orders = null;
        return view('void-orders', compact('users', 'orders'));
    }

    public function showVoidOrders(Request $request)
    {
        $users = [];
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);
        $orders = Order::join('users', 'users.id', '=', 'order.fk_user_id')
            ->where('fk_user_id', $userId)
            ->whereNull('finalized_at')
            ->get(['order.*']);



        return view('void-orders', compact('user', 'orders', 'users'));
    }
}
