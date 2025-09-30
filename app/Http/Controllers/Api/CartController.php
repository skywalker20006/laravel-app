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
}
