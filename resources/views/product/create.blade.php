<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot> 
    <style>
        /* เพิ่มสไตล์ตามต้องการ */
        #description_en {
            height: 500px;
        }
        #description_th {
            height: 500px;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Name and Description -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name_en" class="block text-sm font-medium text-gray-700 white:text-gray-300">Name (EN)</label>
                                <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name_en')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="name_th" class="block text-sm font-medium text-gray-700 white:text-gray-300">Name (TH)</label>
                                <input type="text" name="name_th" id="name_th" value="{{ old('name_th') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name_th')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description_en" class="block text-sm font-medium text-gray-700 white:text-gray-300">Description (EN)</label>
                                <textarea name="description_en" id="description_en" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description_th" class="block text-sm font-medium text-gray-700 white:text-gray-300">Description (TH)</label>
                                <textarea name="description_th" id="description_th" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('description_th') }}</textarea>
                                @error('description_th')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- เลือกหมวดหมู่ -->
                        <div> 
                            <label for="category_id" class="block text-sm font-medium text-gray-700 white:text-gray-300">Category</label>
                            
                            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->translations->where('locale', 'en')->first()->name }} | {{ $category->translations->where('locale', 'jp')->first()->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        
                        <!-- Display Order and Status -->
                        <div class="mt-6">
                            <label for="display_order" class="block text-sm font-medium text-gray-700 white:text-gray-300">Display Order</label>
                            <input type="number" name="display_order" id="display_order" value="{{ old('display_order') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('display_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 white:text-gray-300">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Main Image Upload -->
                        <div class="mt-6">
                            <label for="main_image" class="block text-sm font-medium text-gray-700 white:text-gray-300">Main Product Image</label>
                            <input type="file" name="main_image" id="main_image" class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 white:file:bg-gray-800 white:file:text-gray-400 white:hover:file:bg-gray-700">
                            @error('main_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500 white:text-gray-400">Allowed file types: jpeg, png, jpg. Maximum file size: 5 MB per image.</p>
                        </div> 
 
                        <!-- Images Upload -->
                        <div class="mt-6">
                            <label for="images" class="block text-sm font-medium text-gray-700 white:text-gray-300">Product Images</label>
                            <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 white:file:bg-gray-800 white:file:text-gray-400 white:hover:file:bg-gray-700">
                            @error('images.*')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500 white:text-gray-400">Allowed file types: jpeg, png, jpg. Maximum file size: 5 MB per image.</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
      
    <script> 
        // CKEDITOR.replace('description_en');
        // CKEDITOR.replace('description_th');
         // เริ่มต้น CKEditor
         ClassicEditor
            .create(document.querySelector('#description_en'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#description_th'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
