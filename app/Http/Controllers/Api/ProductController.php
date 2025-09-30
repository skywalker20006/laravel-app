<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // Fetch all products
    public function index()
    {
        $products = Product::all(); // You can use pagination if needed
        return response()->json($products);
    }

    // Fetch a single product by ID
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
}
