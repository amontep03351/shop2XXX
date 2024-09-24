<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('Edit Product Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <form method="POST" action="{{ route('product-categories.update', $productCategory) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name EN -->
                        <div class="mb-4">
                            <label for="name_en" class="block text-sm font-medium text-gray-700">Name (EN)</label>
                            <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $productCategory->translations->where('locale', 'en')->first()->name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_en')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name JP -->
                        <div class="mb-4">
                            <label for="name_th" class="block text-sm font-medium text-gray-700">Name (TH)</label>
                            <input type="text" name="name_th" id="name_th" value="{{ old('name_th', $productCategory->translations->where('locale', 'jp')->first()->name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_th')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
