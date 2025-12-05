<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientCartController extends Controller
{
    // Add to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $product = Product::findOrFail($request->product_id);
        $userId = Auth::id();

        // Check stock
        $inCart = Cart::where('user_id', $userId)->where('product_id', $product->id)->sum('qty');

        if ($inCart >= $product->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add more than available stock.'
            ]);
        }

        // Add one item only
        Cart::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'qty' => 1,
            'price' => $product->sell_price,
            'image' => $product->image,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Added to cart successfully.',
            'cart_count' => Cart::where('user_id', $userId)->count(),
        ]);
    }

    // Cart count (for live display)
    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->count();

        return response()->json(['count' => $count]);
    }

    // Cart page (simple for now)
    public function view()
    {
        $items = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('backend.client.cart', compact('items'));
    }

    public function updateQty(Request $request, Cart $cart)
    {
        $request->validate([
            'action' => 'required|string'
        ]);

        $product = $cart->product;

        if ($request->action === 'plus') {
            if ($cart->qty >= $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock limit reached'
                ]);
            }
            $cart->qty++;
        }

        if ($request->action === 'minus') {
            if ($cart->qty <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimum quantity is 1'
                ]);
            }
            $cart->qty--;
        }

        $cart->save();

        return response()->json([
            'success' => true,
            'qty' => $cart->qty,
            'subtotal' => $cart->qty * $cart->price
        ]);
    }



    public function remove(Cart $cart)
    {
        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}
