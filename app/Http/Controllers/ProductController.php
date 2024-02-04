<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::where('stock', '>', 0)
            ->where('is_enabled', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $discount = Discount::where('status', 'active')
            ->first();
        return view('products', ['product' => $product, 'discount' => $discount]);
    }

    public function search(Request $request)
    {
        $search = $request->input('query');

        $product = Product::where('name', 'like', '%' . $search . '%')
            ->where('stock', '>', 0)
            ->where('is_enabled', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $discount = Discount::where('status', 'active')
            ->first();

        return view('products', compact('search', 'product', 'discount'));
    }
}
