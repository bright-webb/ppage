<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 mx-auto">
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
          Profile
        </h2>
        <p class="text-sm text-gray-600 dark:text-neutral-400">
          Manage your name, password and account settings.
        </p>
      </div>
    <form wire:submit.prevent="save" class="max-w-4xl mx-auto" id="profileForm">
        <div class="grid sm:grid-cols-12 gap-4 sm:gap-6">
            <div class="sm:col-span-3">
                <label class="block text-sm text-gray-700 dark:text-gray-200 mt-2.5">
                    Profile Photo
                </label>
            </div>
            <div class="sm:col-span-9">
                <div class="flex items-center gap-5">
                    @if ($photo)
                        <img class="w-16 h-16 rounded-full ring-2 ring-gray-300 dark:ring-gray-600" src="{{ $photo->temporaryUrl() }}" alt="New profile photo">
                    @else
                        <img class="w-16 h-16 rounded-full ring-2 ring-gray-300 dark:ring-gray-600" src="/storage/{{ $profile->profilePicture }}" alt="Current profile photo">
                    @endif
                    <div>
                        <label for="photo-upload" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700 cursor-pointer">
                            <svg class="w-4 h-4 mr-2 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload photo
                        </label>
                        <input id="photo-upload" type="file" wire:model="photo" class="hidden">
                    </div>
                </div>
                @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="sm:col-span-3">
                <label for="first-name" class="block text-sm text-gray-700 dark:text-gray-200 mt-2.5">
                    Full name
                </label>
            </div>
            <div class="sm:col-span-9">
                <div class="flex">
                    <input id="first-name"  wire:model="firstName" type="text" class="p-2 flex-1 block w-full min-w-0 rounded-l-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="First name" required>
                    <input id="last-name" wire:model="lastName" type="text" class="p-2 flex-1 block w-full min-w-0 -ml-px rounded-r-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Last name" required>
                </div>
                @error('firstName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @error('lastName') <span class="text-red-500 text-xs mt-1">{{ $message }} </span> @enderror
            </div>
            <div class="sm:col-span-3">
                <label for="title" class="block text-sm text-gray-700 dark:text-gray-200 mt-2.5">
                  Title
                </label>
            </div>
              <div class="sm:col-span-9">
                    <input type="text" wire:model="title" id="title" class="p-2 block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Title" required>
                    @error('title')  <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
              </div>
                
                <div class="sm:col-span-3">
                    <label for="company" class="block text-sm text-gray-700 dark:text-gray-200 mt-2.5">
                      Company
                    </label>
                  </div>
                  <div class="sm:col-span-9">
                    <input type="text" wire:model="company" id="company" class="p-2 block w-full rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Company">
                  </div>
    
                  <div class="sm:col-span-3">
                    <label for="email" class="block text-sm text-gray-700 dark:text-gray-200 mt-2.5">
                      Email
                    </label>
                  </div>
                  <div class="sm:col-span-9">
                    <input id="email" wire:model="email" type="email" class="p-2 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="you@example.com" required>
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }} </span> @enderror
                  </div>
    
                 

                  <div class="sm:col-span-3">
                    <label for="phone" class="block text-sm text-gray-700 dark:text-gray-200 mt-2.5">
                      Phone <span class="text-sm text-gray-500 dark:text-gray-400">(Optional)</span>
                    </label>
                  </div>
                  <div class="sm:col-span-9">
                    <div class="flex">
                      <input id="phone" wire:model="phone" type="tel" class="p-2 flex-1 block w-full min-w-0 rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="+1 000 000-0000" required>
                    </div>
                    @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }} </span> @enderror
                  </div>
                  

                   <!-- Bio -->
                <div class="sm:col-span-3">
                    <label for="bio" class="block text-sm text-gray-700 dark:text-gray-200 mt-2.5">
                    Bio
                    </label>
                </div>
                <div class="sm:col-span-9">
                    <textarea id="bio" wire:model="bio" rows="4" class="p-2 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Summary"></textarea>
                </div>
          
</div>
<div class="mt-8 border-t border-gray-200 pt-8">
    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Additional Information</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Provide more details about your location and social media presence.</p>
    
    <div class="mt-6 grid sm:grid-cols-12 gap-4 sm:gap-6">
      <!-- Location Information -->
      <div class="sm:col-span-3">
        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          Country
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="country" name="country" id="country" class="p-2 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-border-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Country">
      </div>

      <div class="sm:col-span-3">
        <label for="state"class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          State/Province
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="state" name="state" id="state" class="p-2 mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="California">
      </div>

      <div class="sm:col-span-3">
        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          City
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text"  wire:model="city" name="city" id="city" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="San Francisco">
      </div>
      
      <!-- Social Media Profiles -->
      <div class="sm:col-span-3">
        <label for="facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          Facebook
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="facebook" name="facebook" id="facebook" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://facebook.com/yourusername">
      </div>

      <div class="sm:col-span-3">
        <label for="twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          Twitter/X
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="twitter" name="twitter" id="twitter" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://twitter.com/yourusername">
      </div>

      <div class="sm:col-span-3">
        <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          LinkedIn
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="linkedin" name="linkedin" id="linkedin" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://linkedin.com/in/yourusername">
      </div>

      <div class="sm:col-span-3">
        <label for="github" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          GitHub
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="github" name="github" id="github" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://github.com/yourusername">
      </div>

      <div class="sm:col-span-3">
        <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          Instagram
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="instagram" name="instagram" id="instagram" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://instagram.com/yourusername">
      </div>

      <div class="sm:col-span-3">
        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          Website
        </label>
      </div>
      <div class="sm:col-span-9">
        <input type="text" wire:model="website" name="website" id="website" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://yourwebsite.com">
      </div>
    </div>
  </div>

      
        <div class="mt-6 flex items-center justify-end gap-x-4">
          <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600">
            Save changes
          </button>
        </div>
    </form>
    @if (session()->has('message'))
    <div class="mt-4 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ session('message') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="mt-4 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {{ session('error') }}
    </div>
@endif
</div>