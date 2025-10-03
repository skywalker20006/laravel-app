<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display the order page with cart items and total price
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

    // Place the order and create an entry in the orders table
    public function placeOrder(Request $request)
    {
        // Retrieve cart items for the current authenticated user
        $cartItems = Cart::where('user_id', auth()->id())->get();

        // Calculate total price
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Add tax calculation (example: 10% tax)
        $tax = $totalPrice * 0.10; // 10% tax
        $totalWithTax = $totalPrice + $tax;

        // Create the order in the orders table
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalWithTax,  // Store price with tax
            'status' => 'pending', // Default status is 'pending'
        ]);

        // After placing the order, clear the cart
        Cart::where('user_id', auth()->id())->delete();

        // Redirect to the checkout page with a success message
        return redirect()->route('checkout', ['orderId' => $order->id]);
    }

    public function checkout($orderId)
    {
        // Fetch the order based on the ID
        $order = Order::find($orderId);

        // Check if the order exists
        if (!$order) {
            return redirect()->route('cart')->with('error', 'Order not found!');
        }

        // Pass the order data to the checkout page (we're not going to pull cart items here)
        return view('products.checkout', compact('order'));
    }

    // Fetch the order and pass it to the orderdetails.blade.php
    public function viewOrderDetails()
    {
        // Fetch all pending orders for the authenticated user
        $orders = Order::where('user_id', auth()->id())  // Get orders for the authenticated user
                        ->where('status', 'pending')  // Optionally filter for pending orders
                        ->with('cartItems.product')  // Eager load cart items and products
                        ->get();

        // Return the order details view with all orders data
        return view('products.orderdetails', compact('orders'));
    }

    // Store order and include tax calculation (this was added as the storeOrder method)
    public function storeOrder(Request $request)
    {
        // Assuming you already have the cart items and total price calculated
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Add tax calculation (example: 10% tax)
        $tax = $totalPrice * 0.10; // 10% tax
        $totalWithTax = $totalPrice + $tax;

        // Store the order with the total price including tax
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalWithTax, // Store price with tax
            'status' => 'pending', // Status is 'pending'
        ]);

        // After placing the order, clear the cart
        Cart::where('user_id', auth()->id())->delete();

        // Redirect to the checkout page with the new order
        return redirect()->route('checkout', ['orderId' => $order->id]);
    }
}
