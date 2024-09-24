<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('Add New Subcategory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <form action="{{ route('product-categories.store_sub', $category) }}" method="POST">
                        @csrf

                        <!-- Name EN -->
                        <div class="mb-4">
                            <label for="name_en" class="block text-sm font-medium text-gray-700">Name (EN)</label>
                            <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_en')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name JP -->
                        <div class="mb-4">
                            <label for="name_th" class="block text-sm font-medium text-gray-700">Name (TH)</label>
                            <input type="text" name="name_th" id="name_th" value="{{ old('name_th') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_th')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Hidden Field for Parent ID -->
                        <input type="hidden" name="parent_id" value="{{ $category->id }}">
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
