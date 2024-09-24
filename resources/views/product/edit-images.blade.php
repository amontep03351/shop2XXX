<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('Manage Product Images') }} - {{ $product->translations->where('locale', 'en')->first()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded-md shadow-md mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form for Uploading New Images -->
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form action=" " method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Display Current Images -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 white:text-gray-300">Current Images</label>
                        @forelse ($images as $image)
                            <div class="relative w-full h-100 border border-gray-300 rounded-lg overflow-hidden bg-gray-100 white:bg-gray-700 mb-4">
                                <img src="{{ Storage::url($image->image_url) }}" alt="Product Image" class="w-full h-full object-cover">
                                <form action="{{ route('productImages.destroy', $image) }}" method="POST" class="absolute top-2 right-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>
                                </form>
                            </div>
                        @empty
                            <div class="p-4 bg-gray-200 white:bg-gray-800 border border-gray-300 rounded-lg text-center">
                                <p class="text-gray-600 white:text-gray-400">No images available.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Upload New Image -->
                    <div class="mb-4">
                        <label for="image_url" class="block text-sm font-medium text-gray-700 white:text-gray-300">Upload New Image (Optional)</label>
                        <input
                            type="file"
                            id="image_url"
                            name="image_url"
                            accept="image/*"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                        />
                        @error('image_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Update Images
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
