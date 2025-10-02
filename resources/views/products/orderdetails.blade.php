{{-- resources/views/products/orderdetails.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @foreach ($orders as $order)
                <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
                    <h3 class="text-2xl font-semibold mb-6">Order Confirmation - Order ID: {{ $order->id }}</h3>
                    <p class="text-gray-600">Thank you for your order!</p>

                    <!-- Order Summary -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold">Order Summary:</h4>
                        <div class="mt-4">
                            <p class="text-sm font-medium">Total Price: ₨{{ number_format($order->total_price, 2) }}</p>
                            <p class="text-sm font-medium">Status: {{ ucfirst($order->status) }}</p>
                        </div>
                    </div>

                    <!-- Show Order Items -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold">Order Items:</h4>
                        <ul class="mt-4">
                            @foreach($order->cartItems as $item)
                                <li class="text-sm">{{ $item->product->title }} - Quantity: {{ $item->quantity }} - Price: ₨{{ number_format($item->product->price, 2) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-6">
                <a href="{{ route('products.index') }}" class="py-3 px-6 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
