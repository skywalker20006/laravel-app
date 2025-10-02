<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Section for Arts -->
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold mb-4">Arts</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($arts as $art)
                            <div class="bg-gray-100 p-4 rounded-lg shadow-lg">
                                <img src="{{ asset('storage/' . $art->image_url) }}" alt="{{ $art->title }}" class="w-full h-48 object-cover rounded-t-lg">
                                <div class="mt-4">
                                    <p class="font-semibold text-lg">{{ $art->title }}</p>
                                    <p class="text-gray-600">₨{{ number_format($art->price, 2) }}</p>
                                    <a href="{{ route('arts') }}" class="mt-2 inline-block bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                                        Explore More
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section for Collectibles -->
                <div>
                    <h3 class="text-2xl font-semibold mb-4">Collectibles</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($collectibles as $collectible)
                            <div class="bg-gray-100 p-4 rounded-lg shadow-lg">
                                <img src="{{ asset('storage/' . $collectible->image_url) }}" alt="{{ $collectible->title }}" class="w-full h-48 object-cover rounded-t-lg">
                                <div class="mt-4">
                                    <p class="font-semibold text-lg">{{ $collectible->title }}</p>
                                    <p class="text-gray-600">₨{{ number_format($collectible->price, 2) }}</p>
                                    <a href="{{ route('collectibles') }}" class="mt-2 inline-block bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                                        Explore More
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
