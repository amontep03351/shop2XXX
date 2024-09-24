<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('About Us') }}
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
            <!-- About Us Form -->
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <form action="{{ route('aboutus.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title_en" class="block text-sm font-medium text-gray-700 white:text-gray-300">About Us Title (EN)</label>
                            <input type="text" id="title_en" name="title_en" value="{{ old('title_en', $aboutUs->title_en) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-6">
                            <label for="title_th" class="block text-sm font-medium text-gray-700 white:text-gray-300">About Us Title (TH)</label>
                            <input type="text" id="title_th" name="title_th" value="{{ old('title_th', $aboutUs->title_th) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description_en" class="block text-sm font-medium text-gray-700 white:text-gray-300">About Us Description (EN)</label>
                            <textarea id="description_en" name="description_en" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description_en', $aboutUs->description_en) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label for="description_th" class="block text-sm font-medium text-gray-700 white:text-gray-300">About Us Description (TH)</label>
                            <textarea id="description_th" name="description_th" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description_th', $aboutUs->description_th) }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Image Upload Form -->
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-8">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <h3>Main Image</h3>
                    <p class="mt-2 text-sm text-gray-500 white:text-gray-400">Allowed file types: jpeg, png, jpg. Maximum file size: 5 MB per image. Image dimensions: 479.6 x 479.6 pixels.</p>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg border border-gray-300 hover:shadow-xl transition-shadow duration-300">
                        <!-- Image -->
                        @if ($aboutUs->image)
                            <img src="{{ asset('storage/app/public/'.$aboutUs->image) }}" alt="About Us Image" class="w-full h-100 object-cover transition-transform duration-300 group-hover:scale-110">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>
                        @endif

                        <!-- Change Image Button -->
                        <button type="button" class="absolute bottom-2 right-2 bg-blue-600 text-white px-3 py-1 text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="document.getElementById('image-upload-input').click();">
                            Change Image
                        </button>
 
                    </div>

                   <!-- Hidden Form for Image Upload -->
                    <form id="image-upload-form" method="POST" action="{{ route('aboutus.update.image') }}" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        @method('PUT')
                        <input type="file" id="image-upload-input" name="image" class="hidden" accept="image/*" onchange="document.getElementById('image-upload-form').submit();">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>  
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
