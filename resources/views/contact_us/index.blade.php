<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 white:text-gray-200 leading-tight">
            {{ __('Contact Us') }}
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

            <!-- Contact Us Form -->
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    <form action="{{ route('contactus.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Address (EN) -->
                        <div class="mb-6">
                            <label for="address_en" class="block text-sm font-medium text-gray-700">Address (EN)</label>
                            <textarea id="address_en" name="address_en" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address_en', $contactUs->address_en) }}</textarea>
                        </div>

                        <!-- Address (TH) -->
                        <div class="mb-6">
                            <label for="address_th" class="block text-sm font-medium text-gray-700">Address (TH)</label>
                            <textarea id="address_th" name="address_th" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address_th', $contactUs->address_th) }}</textarea>
                        </div>
                        <!-- Mail -->
                        <div class="mb-6">
                            <label for="mail" class="block text-sm font-medium text-gray-700 white:text-gray-300">Email</label>
                            <input type="text" id="mail" name="mail" value="{{ old('mail', implode(', ', json_decode($contactUs->mail, true) ?? [])) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <small class="text-gray-500">Separate emails with commas</small>
                        </div>

                        <!-- Telephone -->
                        <div class="mb-6">
                            <label for="tel" class="block text-sm font-medium text-gray-700 white:text-gray-300">Phone Numbers</label>
                            <input type="text" id="tel" name="tel" value="{{ old('tel', implode(', ', json_decode($contactUs->tel, true) ?? [])) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <small class="text-gray-500">Separate phone numbers with commas</small>
                        </div>

                        <!-- Facebook Link -->
                        <div class="mb-6">
                            <label for="linkfacebook" class="block text-sm font-medium text-gray-700 white:text-gray-300">Facebook Link</label>
                            <input type="text" id="linkfacebook" name="linkfacebook" value="{{ old('linkfacebook', $contactUs->linkfacebook) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <!-- YouTube Link -->
                        <div class="mb-6">
                            <label for="linkyoutube" class="block text-sm font-medium text-gray-700 white:text-gray-300">YouTube Link</label>
                            <input type="text" id="linkyoutube" name="linkyoutube" value="{{ old('linkyoutube', $contactUs->linkyoutube) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <!-- Map Location -->
                        <div class="mb-6">
                            <label for="maplocation" class="block text-sm font-medium text-gray-700 white:text-gray-300">Map Location</label>
                            <input type="text" id="maplocation" name="maplocation" value="{{ old('maplocation', $contactUs->maplocation) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Contact Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
         // เริ่มต้น CKEditor
         ClassicEditor
            .create(document.querySelector('#address_en'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#address_th'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error);
            });
      
    </script>
</x-app-layout>
