<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Check if the user has the 'admin' role
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Get all products
            $products = Product::all();

            // Return the view with products
            return view('products.admin', compact('products'));
        }

        // Redirect back if the user is not an admin
        return redirect('/')->with('error', 'You do not have access to this page.');
    }

    public function edit($id)
    {
        // Check if the user has the 'admin' role
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Find the product by ID
            $product = Product::findOrFail($id);

            // Return the edit view with the product
            return view('products.edit', compact('product'));
        }

        // Redirect back if the user is not an admin
        return redirect('/')->with('error', 'You do not have access to this page.');
    }

    public function update(Request $request, $id)
    {
        // Check if the user has the 'admin' role
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Validate and update the product
            $product = Product::findOrFail($id);

            // Update the product details
            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'category' => $request->category,
                'image_url' => $request->file('image_url') 
                    ? $request->file('image_url')->store('images', 'public') 
                    : $product->image_url,
            ]);

            return redirect()->route('admin')->with('success', 'Product updated successfully!');
        }

        // Redirect back if the user is not an admin
        return redirect('/')->with('error', 'You do not have access to this page.');
    }

    public function destroy($id)
    {
        // Check if the user has the 'admin' role
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Find and delete the product
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('admin')->with('success', 'Product deleted successfully!');
        }

        // Redirect back if the user is not an admin
        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}
