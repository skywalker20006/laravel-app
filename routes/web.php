<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    // Redirect to products.index by default
    return redirect()->route('products.index');
});

// Protected routes for authenticated users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route for the products index page
    Route::get('/products', function () {
        return view('products.index'); // Show products index page
    })->name('products.index');

    // Route for the dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // New route for the arts page
    Route::get('/arts', function () {
        return view('products.arts'); // New arts page
    })->name('arts');

    // Route for the collectibles page
    Route::get('/collectibles', function () {
        return view('products.collectibles'); // Collectibles page
    })->name('collectibles');

    // Route for the cart page
    Route::get('/cart', function () {
        return view('products.cart'); // Cart page
    })->name('cart');

    //i had my old admin route i deleted here

    // Handle the form submission for creating a product
    Route::post('/admin/create', function () {
       

        // Validate the form data
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|in:arts,collectibles',
            'image_url' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',  // Validation for image file
        ]);

        // Check if there is a file uploaded and store it in the public/images folder
        if (request()->hasFile('image_url')) {
            // Store the image file and get its path
            $imagePath = request()->file('image_url')->store('images', 'public'); // Storing the image in public/images
            $data['image_url'] = $imagePath; // Save the file path in the database
        } else {
            // If no file is uploaded, you can set a default or handle it
            $data['image_url'] = 'default_image_path.jpg'; // Example if there's no image uploaded
        }

        // Create the product using the validated data
        \App\Models\Product::create($data);

        // Redirect back to the admin dashboard with a success message
        return redirect()->route('admin')->with('success', 'Product added successfully!');
    })->name('admin.create');
});

Route::get('/arts', function () {
    $arts = \App\Models\Product::where('category', 'arts')->get();
    return view('products.arts', compact('arts'));
})->name('arts');


Route::get('/collectibles', function () {
    $collectibles = \App\Models\Product::where('category', 'collectibles')->get();
    return view('products.collectibles', compact('collectibles'));
})->name('collectibles');



//cart page
Route::get('/cart', function () {
    $cartItems = \App\Models\Cart::with('product')->where('user_id', auth()->id())->get();

    $totalPrice = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

    return view('products.cart', compact('cartItems', 'totalPrice'));
})->name('cart');


// Remove item from cart
Route::delete('/cart/{id}', function ($id) {
    \App\Models\Cart::destroy($id);
    return redirect()->route('cart')->with('success', 'Item removed from cart');
})->name('cart.remove');






// Add product to cart
Route::post('/cart/add/{product}', function (\App\Models\Product $product) {
    $user = auth()->user();

    // Check if the product is already in the cart
    $cartItem = \App\Models\Cart::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->first();

    if ($cartItem) {
        // If it exists, increment the quantity
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        // Otherwise, create a new cart item
        \App\Models\Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart!');
})->name('cart.add');



Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Order page (with cart items and total price)
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');

    // Place order (POST request)
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');

    // Checkout page (order summary)
    Route::get('/checkout/{orderId}', [OrderController::class, 'checkout'])->name('checkout');

    // Order details route
    Route::get('/order/{orderId}', [OrderController::class, 'viewOrderDetails'])->name('order.details');
});


//new shit for the admin column i added in the db so only dulya should see the admin page
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});



Route::get('/', function () {
    // Fetch 4 arts products
    $arts = \App\Models\Product::where('category', 'arts')->take(4)->get(); // Fetch only 4 products

    // Fetch 4 collectibles products
    $collectibles = \App\Models\Product::where('category', 'collectibles')->take(4)->get(); // Fetch only 4 products

    // Pass the data to the index view
    return view('products.index', compact('arts', 'collectibles'));
})->name('products.index');























Route::get('/', function () {
    // Check if the user is authenticated
    if (auth()->check()) {
        $arts = \App\Models\Product::where('category', 'arts')->take(4)->get(); // Fetch only 4 arts products
        $collectibles = \App\Models\Product::where('category', 'collectibles')->take(4)->get(); // Fetch only 4 collectibles

        // Pass the data to the homepage view
        return view('products.homepage', compact('arts', 'collectibles'));
    }
    
    // If not authenticated, redirect to the register page
    return redirect()->route('register');
})->name('home');





//this should pull products and i should be able to edit and delete em it the admin page
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Admin route to display all products
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    // Edit product route
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');

    // Update product route
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');

    // Delete product route
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
});



