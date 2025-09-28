<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Collectibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($collectibles as $product)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover rounded-md mb-2">
                        <h3 class="font-semibold text-lg">{{ $product->title }}</h3>
                        <p class="text-gray-600">{{ $product->description }}</p>
                        <p class="font-bold mt-1">₨{{ number_format($product->price, 2) }}</p>
                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf
                            <button type="submit" class="mt-2 w-full bg-indigo-600 text-white py-1 rounded hover:bg-indigo-700">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                @empty
                    <p>No collectibles available yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
