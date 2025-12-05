<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;

class CheckoutController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cart->isEmpty()) {
            return redirect()->route('client.dashboard')->with('error', 'Cart is empty');
        }

        $cartTotal = $cart->sum(function ($item) {
            return $item->price * $item->qty;
        });

        return view('backend.client.checkout', compact('user', 'cart', 'cartTotal'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'postal_code' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cart->isEmpty()) {
            return redirect()->route('client.dashboard')->with('error', 'Your cart is empty.');
        }


        DB::beginTransaction();
        try {

            // 1️⃣ Save Address
            $address = Address::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'postal_code' => $request->postal_code,
                'country' => $request->country ?? 'Pakistan',
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
            ]);

            // 2️⃣ Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'total_amount' => $request->cart_total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method == 'COD' ? 'pending' : 'processing',
                'order_status' => 'processing'
            ]);

            // 3️⃣ Save Order Items + Stock Deduction
            foreach ($cart as $item) {

                if ($item->qty > $item->product->stock) {
                    throw new \Exception("Product {$item->product->title} is out of stock");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'subtotal' => $item->qty * $item->price
                ]);

                // Deduct stock
                $item->product->decrement('stock', $item->qty);
            }

            // 4️⃣ Clear Cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();
            Mail::to($order->address->email)->send(new OrderPlacedMail($order));


            return redirect()->route('client.dashboard')
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
