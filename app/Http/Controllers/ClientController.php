<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        // Show 10 products per page → 5 cards per row → 2 rows
        $products = Product::orderBy('id', 'desc')->paginate(10);

        return view('backend.client.dashboard', compact('products'));
    }

    public function orders()
    {
        return view('backend.client.orders'); // empty for now
    }
}
