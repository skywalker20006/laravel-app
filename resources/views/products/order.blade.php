<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex space-x-8">

                <!-- Left Modal: Cart Items -->
                <div class="w-2/3 bg-white p-6 shadow-lg rounded-lg overflow-auto">
                    <h3 class="text-2xl font-semibold mb-6">Your Order</h3>

                    @forelse($cartItems as $item)
                        <div class="flex items-center justify-between border-b py-4">
                            <div class="flex items-center space-x-6">
                                <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->title }}" class="w-20 h-20 object-cover rounded-lg">
                                <div class="flex flex-col">
                                    <p class="font-semibold text-lg">{{ $item->product->title }}</p>
                                    <p class="text-gray-600 text-sm">₨{{ number_format($item->product->price, 2) }}</p>
                                    <p class="text-gray-500 text-sm">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">Your cart is empty.</p>
                    @endforelse
                </div>

                <!-- Right Modal: Fixed Total Price & Confirm Order Button -->
                <div class="w-1/3 bg-gray-100 p-6 rounded-lg shadow-lg flex flex-col justify-between h-80">
                    <div class="flex flex-col justify-between">
                        <h4 class="font-semibold text-xl mb-4">Order Summary</h4>
                        <div class="text-lg text-gray-700">
                            <div class="flex justify-between py-2">
                                <span class="font-medium">Subtotal:</span>
                                <span>₨{{ number_format($totalPrice, 2) }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="font-medium">Taxes & Fees:</span>
                                <span>₨{{ number_format($totalPrice * 0.10, 2) }}</span> <!-- Example tax calculation -->
                            </div>
                            <div class="border-t border-gray-300 my-4"></div>
                            <div class="flex justify-between text-xl font-semibold py-2">
                                <span>Total Balance:</span>
                                <span class="text-green-600">₨{{ number_format($totalPrice + ($totalPrice * 0.10), 2) }}</span> <!-- Total after tax -->
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-6">
                        <button class="py-3 px-6 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                            Confirm Order
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
