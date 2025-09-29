<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex space-x-8">

                <!-- First Modal: Cart Items -->
                <div class="w-2/3 bg-white p-6 shadow-lg rounded-lg overflow-auto">
                    <h3 class="text-lg font-semibold mb-4">Your Order</h3>

                    @forelse($cartItems as $item)
                        <div class="flex items-center justify-between border-b py-3">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->title }}" class="w-16 h-16 object-cover rounded">
                                <div>
                                    <p class="font-semibold">{{ $item->product->title }}</p>
                                    <p class="text-gray-600">₨{{ number_format($item->product->price, 2) }}</p>
                                    <p class="text-gray-500">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">Your cart is empty.</p>
                    @endforelse
                </div>

                <!-- Second Modal: Fixed Total Price and Confirm Button -->
                <div class="w-1/3 bg-gray-100 p-6 rounded-lg shadow flex flex-col justify-between h-80">
                    <div>
                        <h4 class="font-semibold text-lg">Total Price</h4>
                        <p class="font-bold text-xl">₨{{ number_format($totalPrice, 2) }}</p>
                    </div>

                    <div class="text-center mt-6">
                        <button class="py-2 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Confirm Order
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
