<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Your Cart</h3>

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
                        <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Remove</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-600">Your cart is empty.</p>
                @endforelse

                {{-- Total Price (below cart items) --}}
                @if($cartItems->count() > 0)
                    <div class="mt-6 p-4 bg-gray-100 rounded-lg flex justify-between items-center">
                        <h3 class="font-semibold text-lg">Total Price:</h3>
                        <p class="font-bold text-xl">₨{{ number_format($totalPrice, 2) }}</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Fixed Total Price at bottom --}}
    @if($cartItems->count() > 0)
        <div class="fixed bottom-4 left-0 w-full max-w-5xl mx-auto px-6">
            <div class="p-4 bg-gray-100 rounded-lg flex justify-between items-center shadow">
                <h3 class="font-semibold text-lg">Total Price:</h3>
                <p class="font-bold text-xl">₨{{ number_format($totalPrice, 2) }}</p>
            </div>
        </div>
    @endif
</x-app-layout>
