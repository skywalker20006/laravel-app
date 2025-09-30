<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
});