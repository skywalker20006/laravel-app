<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Add Product Form -->
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Add New Product</h3>
                <form method="POST" action="{{ route('admin.create') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" id="category"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="arts">Arts</option>
                            <option value="collectibles">Collectibles</option>
                        </select>
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image_url" id="image_url" accept="image/*" required
                               class="mt-1 block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Add Product
                        </button>
                    </div>
                </form>

                <!-- List of Existing Products -->
                <h3 class="text-lg font-semibold text-gray-700 mt-8 mb-4">Existing Products</h3>
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Title</th>
                            <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Category</th>
                            <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Price</th>
                            <th class="px-6 py-3 border-b text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">{{ $product->title }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">{{ ucfirst($product->category) }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">₨{{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.edit', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('admin.delete', $product->id) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline ml-4">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
