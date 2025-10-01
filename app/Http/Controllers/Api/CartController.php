<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    // Add a product to the cart
    public function add($productId)
    {
        $user = auth()->user();
        $product = Product::findOrFail($productId);

        // Check if the product is already in the user's cart
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            // Increment quantity if product already in cart
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // Add product to cart
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return response()->json(['message' => 'Product added to cart']);
    }

    // Remove an item from the cart
    public function remove($cartId)
    {
        $cartItem = Cart::findOrFail($cartId);
        $cartItem->delete();
        
        return response()->json(['message' => 'Item removed from cart']);
    }

    // View cart items for the authenticated user
    public function index()
    {
        $user = auth()->user();  // Get the authenticated user
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();  // Fetch cart items with associated products

        // Return the cart items as a JSON response
        return response()->json($cartItems);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();  // Get the authenticated user

        // Find the cart item by its ID
        $cartItem = Cart::where('user_id', $user->id)->findOrFail($id);

        // Validate the incoming quantity (e.g., make sure it's a positive integer)
        $request->validate([
          'quantity' => 'required|integer|min:1',  // Quantity should be at least 1
        ]);

        // Update the quantity
        $cartItem->quantity = $request->quantity;
        $cartItem->save();  // Save the changes

        return response()->json(['message' => 'Cart item quantity updated']);
    }

    

}
