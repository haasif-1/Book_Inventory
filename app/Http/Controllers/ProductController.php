<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List page
    public function index()
    {
        return view('backend.clerk.products');
    }

    // Table data (AJAX)
    public function data(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($w) use ($s) {
                $w->where('title', 'like', "%$s%")
                  ->orWhere('sku', 'like', "%$s%")
                  ->orWhere('location', 'like', "%$s%")
                  ->orWhere('description', 'like', "%$s%");
            });
        }

        $products = $query->orderBy('title')->get();

        $data = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'sku' => $p->sku,
                'title' => $p->title,
                'stock' => $p->stock,
                'min_stock' => $p->min_stock,
                'sell_price' => $p->sell_price,
                'image' => $p->image ? asset('storage/'.$p->image) : null,
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    // Create
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'sku' => 'nullable|unique:products,sku',
            'cost_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'sku', 'title', 'cost_price', 'sell_price', 'stock',
            'min_stock', 'reorder_point', 'description', 'location'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['created_by'] = Auth::id();

        $product = Product::create($data);

        return response()->json(['success' => true, 'message' => 'Product created']);
    }

    // Show one (AJAX)
    public function show(Product $product)
    {
        return response()->json(['success' => true, 'data' => $product]);
    }

    // Update
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'sku' => 'nullable|unique:products,sku,' . $product->id,
            'cost_price' => 'nullable|numeric|min:0',
            'sell_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'sku', 'title', 'cost_price', 'sell_price', 'stock',
            'min_stock', 'reorder_point', 'description', 'location'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return response()->json(['success' => true, 'message' => 'Product updated']);
    }

    // Delete
    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted']);
    }

    // Stock adjust
    public function adjustStock(Request $request, Product $product)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'type' => 'required|in:add,remove',
        ]);

        $amount = $request->amount;

        if ($request->type === 'add') {
            $product->stock += $amount;
        } else {
            $product->stock = max(0, $product->stock - $amount);
        }

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Stock updated',
            'stock' => $product->stock
        ]);
    }
}
