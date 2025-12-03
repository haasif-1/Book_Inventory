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
}
