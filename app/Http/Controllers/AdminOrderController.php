<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'address')->latest()->paginate(20);
        return view('backend.admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'address');
        return view('backend.admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:processing,packed,shipped,delivered,cancelled'
        ]);

        $order->update(['order_status' => $request->status]);

        return back()->with('success', 'Order status updated');
    }
}
