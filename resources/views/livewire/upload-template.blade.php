<div class="max-w-lg p-6 bg-white rounded-lg shadow-md">
    @if (session()->has('message'))
        <div class="text-green-500 mb-4">
            {{ session('message') }}
        </div>
    @elseif (session()->has('error'))
        <div class="text-red-500 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="uploadTemplate" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Template Name</label>
            <input type="text" wire:model="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500" placeholder="Enter template name">
            @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="file" class="block text-sm font-medium text-gray-700">Upload Zip File</label>

            <div class="relative mt-2 max-w-lg">
                <input wire:model="file" type="file" id="file" class="file-input absolute inset-0 w-full h-full opacity-0 z-50 cursor-pointer" />
                <div class="file-label flex justify-center items-center border border-dashed border-gray-300 p-4 rounded-md bg-white cursor-pointer">
                    <div class="text-center">
                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V8m4 8V4m4 8v4m4 0a2 2 0 11-4 0 2 2 0 014 0zM4 12v4a4 4 0 004 4h8a4 4 0 004-4v-4M4 12a4 4 0 004-4V6a4 4 0 00-8 0v4z"></path>
                        </svg>
                        <p class="text-sm text-gray-600">Drag and drop or click to upload</p>
                    </div>
                </div>
            </div>

           
            @if ($file)
                <div class="mt-2 text-sm text-gray-600">
                    Selected file: {{ $file->getClientOriginalName() }}
                </div>
            @endif

            @error('file') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 sm:text-sm" placeholder="Enter description of the template"></textarea>
            @error('description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
        </div>
        
        <div wire:loading wire:target="file" class="mt-2 text-sm text-gray-500">
            Uploading...
        </div>


        <!-- Submit Button with Spinner -->
        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <div wire:loading.remove wire:target="uploadTemplate">
                Upload Template
            </div>
            <div wire:loading wire:target="uploadTemplate">
                Uploading...
            </div>
        </button>
    </form>
</div>
