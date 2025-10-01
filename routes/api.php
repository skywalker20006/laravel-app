<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\ApiOrderController;



Route::post('/login', [AuthController::class, 'login']);



Route::post('/register', [AuthController::class, 'register']);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// API routes for products and cart
Route::middleware('auth:sanctum')->group(function () {
    // Product routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    // Cart routes
    Route::post('/cart/add/{product}', [CartController::class, 'add']);
    Route::delete('/cart/{id}', [CartController::class, 'remove']);

    // Viewing the cart items (protected route)
    Route::get('/cart', [CartController::class, 'index']);

    // Update cart item quantity
    Route::put('/cart/update/{id}', [CartController::class, 'update']);





    // Order routes
    Route::get('/order', [ApiOrderController::class, 'index']);  // View order summary
    Route::post('/place-order', [ApiOrderController::class, 'placeOrder']);  // Place an order
    Route::get('/order/{orderId}', [ApiOrderController::class, 'checkout']);  // View order details (checkout)
});

