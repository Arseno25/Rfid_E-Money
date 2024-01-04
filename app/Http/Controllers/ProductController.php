<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        $product = Product::where('stock', '>', 0)->where('is_enabled', 1)->paginate(3);
        return view('products', ['product' => $product]);
    }
}
