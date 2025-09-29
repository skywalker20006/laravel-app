<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display the order page
    public function index()
    {
        // Get cart items for the current authenticated user
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Calculate total price of cart items
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Return the order view with the cart items and total price
        return view('products.order', compact('cartItems', 'totalPrice'));
    }
}
