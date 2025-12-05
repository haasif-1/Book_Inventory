<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function lowStock(Request $request)
    {
        // filter value
        $threshold = $request->input('threshold');

        $query = Product::query();

        // if filter applied
        if ($threshold !== null) {
            $query->where('stock', '<=', (int)$threshold);
        } else {
            // default: show min-stock products
            $query->whereColumn('stock', '<=', 'min_stock');
        }

        $products = $query->orderBy('stock')->get();

        return view('backend.admin.lowstock', compact('products','threshold'));
    }

  public function productsPage()
{
    return view('backend.admin.products');
}

public function productsData(Request $request)
{
    $search = $request->search;

    $query = Product::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('sku', 'like', "%$search%")
              ->orWhere('location', 'like', "%$search%");
        });
    }

    // max 10 rows
    $products = $query->orderBy('id', 'desc')->paginate(10);

    return response()->json([
        'success' => true,
        'data' => $products->items(),
        'pagination' => [
            'current' => $products->currentPage(),
            'last' => $products->lastPage(),
        ]
    ]);
}


}
