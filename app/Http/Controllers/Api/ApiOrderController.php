<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiOrderController extends Controller
{
    // Display the order summary for the authenticated user
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

        // Return the order summary with cart items and total price
        return response()->json([
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    // Place an order and create an entry in the orders table
    public function placeOrder(Request $request)
    {
        // Retrieve cart items for the current authenticated user
        $cartItems = Cart::where('user_id', auth()->id())->get();

        // Calculate total price
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Create the order in the orders table
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'status' => 'pending', // Default status is 'pending'
        ]);

        // After placing the order, clear the cart
        Cart::where('user_id', auth()->id())->delete();

        // Return success response with order details
        return response()->json([
            'message' => 'Order placed successfully!',
            'order' => $order,
        ], 201);
    }

    // Fetch the order details based on the order ID
    public function checkout($orderId)
    {
        // Fetch the order based on the ID
        $order = Order::with('user')->find($orderId);

        // Check if the order exists
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Return the order details as a JSON response
        return response()->json(['order' => $order]);
    }
}
