<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name and Description -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name_en" class="block text-sm font-medium text-gray-700 white:text-gray-300">Name (EN)</label>
                                <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $product->translations->where('locale', 'en')->first()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name_en')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="name_th" class="block text-sm font-medium text-gray-700 white:text-gray-300">Name (TH)</label>
                                <input type="text" name="name_th" id="name_th" value="{{ old('name_th', $product->translations->where('locale', 'jp')->first()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name_th')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description_en" class="block text-sm font-medium text-gray-700 white:text-gray-300">Description (EN)</label>
                                <textarea name="description_en" id="description_en" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('description_en', $product->translations->where('locale', 'en')->first()->description) }}</textarea>
                                @error('description_en')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="description_th" class="block text-sm font-medium text-gray-700 white:text-gray-300">Description (TH)</label>
                                <textarea name="description_th" id="description_th" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('description_th', $product->translations->where('locale', 'jp')->first()->description) }}</textarea>
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
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                            {{ $category->translations->where('locale', 'en')->first()->name }} | {{ $category->translations->where('locale', 'jp')->first()->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Display Order and Status -->
                        <div class="mt-6">
                            <label for="display_order" class="block text-sm font-medium text-gray-700 white:text-gray-300">Display Order</label>
                            <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $product->display_order) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @error('display_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 white:text-gray-300">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="1" {{ old('status', $product->status) === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $product->status) === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Product
                            </button>
                        </div>
                        </form>
                        <hr class="my-6 border-gray-300 white:border-gray-700">
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">There were some problems with your input.</strong>
                                <ul class="list-disc mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Success Message -->
                        @if (session('success'))
                            <br>
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <strong class="font-bold">Success!</strong>
                                <span class="block sm:inline">{{ session('success') }}</span>
                                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.933 2.935a1 1 0 01-1.414-1.414L8.586 10 5.651 7.065a1 1 0 011.414-1.414L10 8.586l2.933-2.935a1 1 0 011.414 1.414L11.414 10l2.935 2.933a1 1 0 010 1.414z"/></svg>
                                </span>
                            </div>      
                        @endif
                        <!-- Main Image -->
                        <h3>Main Image</h3>
                        <p class="mt-2 text-sm text-gray-500 white:text-gray-400">Allowed file types: jpeg, png, jpg. Maximum file size: 5 MB per image.</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mt-6">  
                            
                            <div class="relative group overflow-hidden rounded-lg shadow-lg border border-gray-300 hover:shadow-xl transition-shadow duration-300">
                                <!-- Image -->
                                <img src="{{ asset('storage/app/public/'.$product->product_image) }}" alt="Product Image" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                
                                <!-- Edit Button -->
                                <button type="button" class="absolute bottom-2 right-2 bg-blue-600 text-white px-3 py-1 text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="document.getElementById('edit-image-input').click();">
                                    Change Image
                                </button>
                            </div>

                            <!-- Hidden Input for Image Upload -->
                            <form id="image-upload-form" method="POST" action="{{ route('products.update.image', $product->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="file" id="edit-image-input" name="product_image" class="hidden" accept="image/*" onchange="document.getElementById('image-upload-form').submit();">
                            </form>
                        </div>
                        <hr class="my-6 border-gray-300 white:border-gray-700">
                        <h3>Additional Images</h3>
                        <p class="mt-2 text-sm text-gray-500 white:text-gray-400">Allowed file types: jpeg, png, jpg. Maximum file size: 5 MB per image. You can select multiple images.</p>
                        <!-- Additional Images -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mt-6">  
                            <!-- Loop through existing images -->
                            @foreach($images as $image)
                                <div class="relative group overflow-hidden rounded-lg shadow-lg border border-gray-300 hover:shadow-xl transition-shadow duration-300">
                                    <!-- Image -->
                                    <img src="{{ asset('storage/app/public/'.$image->image_url) }}" alt="Product Image" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                    
                                    <!-- Overlay for Delete Button -->
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <!-- Delete Button -->
                                        <button type="button" onclick="if (confirm('Are you sure you want to delete this image?')) { document.getElementById('delete-form-{{ $image->id }}').submit(); }" class="text-white bg-red-600 hover:bg-red-800 p-2 rounded-full focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Delete Form -->
                                    <form id="delete-form-{{ $image->id }}" action="{{ route('product_images.destroy', $image->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            @endforeach

                            <!-- Add new image button -->
                            <div class="relative group overflow-hidden rounded-lg shadow-lg border border-dashed border-gray-300 hover:shadow-xl transition-shadow duration-300 cursor-pointer">
                                <!-- Plus icon for adding new image -->
                                <label for="add-image" class="flex items-center justify-center w-full h-48 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 group-hover:text-blue-500 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </label>
                                <form action="{{ route('images.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input id="add-image" type="file" name="additional_images[]" class="hidden" accept="image/*" multiple onchange="this.form.submit()">
                                </form> 
                                
                            </div>
                        </div>
                        

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