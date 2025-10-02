<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Check if the user has the 'admin' role
        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('products.admin'); // Show admin dashboard if user is an admin
        }

        // Redirect back if the user is not an admin
        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}
