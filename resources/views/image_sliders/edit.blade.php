<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('Edit Image Slider') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <form method="POST" action="{{ route('image_sliders.update', $imageSlider->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Title EN -->
                            <div>
                                <x-input-label for="title_en" :value="__('Title (EN)')" />
                                <x-text-input id="title_en" name="title_en" type="text" value="{{ old('title_en', $imageSlider->title_en) }}" required autofocus />
                                <x-input-error :messages="$errors->get('title_en')" class="mt-2" />
                            </div>

                            <!-- Title JP -->
                            <div>
                                <x-input-label for="title_th" :value="__('Title (TH)')" />
                                <x-text-input id="title_th" name="title_th" type="text" value="{{ old('title_th', $imageSlider->title_th) }}" required />
                                <x-input-error :messages="$errors->get('title_th')" class="mt-2" />
                            </div>

                            <!-- Description EN -->
                            <div>
                                <x-input-label for="description_en" :value="__('Description (EN)')" />
                                <textarea id="description_en" name="description_en" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('description_en', $imageSlider->description_en) }}</textarea>
                                <x-input-error :messages="$errors->get('description_en')" class="mt-2" />
                            </div>

                            <!-- Description JP -->
                            <div>
                                <x-input-label for="description_th" :value="__('Description (TH)')" />
                                <textarea id="description_th" name="description_th" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('description_th', $imageSlider->description_th) }}</textarea>
                                <x-input-error :messages="$errors->get('description_th')" class="mt-2" />
                            </div>

                            <!-- Image -->
                            <div>
                                <x-input-label for="image_url" :value="__('Image')" />
                                @if ($imageSlider->image_url)
                                    <img src="{{ asset('storage/app/public/'.$imageSlider->image_url) }}" alt="Image" class="w-24 h-24 object-cover">
                                @endif
                                <input id="image_url" name="image_url" type="file" />
                                <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
                            </div>

                            <!-- Display Order -->
                            <div>
                                <x-input-label for="display_order" :value="__('Display Order')" />
                                <x-text-input id="display_order" name="display_order" type="number" min="0" value="{{ old('display_order', $imageSlider->display_order) }}" required />
                                <x-input-error :messages="$errors->get('display_order')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    <option value="1" {{ old('status', $imageSlider->status) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $imageSlider->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                        
                               <!-- Submit Button -->
                            <div class="flex items-center justify-end">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                            </div>
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
