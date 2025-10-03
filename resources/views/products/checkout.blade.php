<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h3 class="text-2xl font-semibold mb-6">Thank You for Your Order!</h3>
                <p class="text-gray-600">Your order has been placed successfully.</p>

                <!-- Order Summary -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold">Order Summary:</h4>
                    <div class="mt-4">
                        <p class="text-sm font-medium">Order ID: {{ $order->id }}</p>
                        <p class="text-sm font-medium">Total Price: ₨{{ number_format($order->total_price, 2) }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-lg">You can track your order status in your account later.</p>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('home') }}" class="py-3 px-6 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
