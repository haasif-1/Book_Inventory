<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Show all orders for authenticated client
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('backend.client.orders.index', compact('orders'));
    }


    // Single order page
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product', 'address');

        return view('backend.client.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        if ($order->order_status !== 'processing') {
            return back()->with('error', 'Order cannot be cancelled.');
        }

        $order->update(['order_status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully.');
    }

    public function invoice(Order $order)
{
    if ($order->user_id !== Auth::id()) abort(403);

    $order->load('items.product', 'address');

    $pdf = Pdf::loadView('backend.client.orders.invoice', compact('order'));

    return $pdf->download("invoice-{$order->id}.pdf");
}
}
