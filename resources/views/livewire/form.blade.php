<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md" wire:id="template-form">
    <h3 class="text-xl font-bold mb-4">{{ $template->name }}</h3>
    <div class="divider mb-4"></div>
    
    <form  enctype="multipart/form-data">
      @foreach ($schema as $fieldName => $fieldType)
        @php
        $fieldParts = explode('|', $fieldType);
        $baseType = $fieldParts[0];
        $required = null;
        if(isset($fieldParts[1])){
            $required = $fieldParts[1];
        }
      
        @endphp
       
      <div class="mb-4">
          @if($baseType === 'avatar')
              <div class="w-full flex justify-center items-center mb-4">
                <div data-hs-file-upload='{
                  "url": "/upload",
                  "acceptedFiles": "image/*",
                  "maxFiles": 1,
                  "singleton": true
                }'>
                  <template data-hs-file-upload-preview="">
                    <div class="size-20">
                      <img src="/images/mock.png" class="w-full object-contain rounded-full">
                    </div>
                  </template>
                  <div class="flex flex-wrap items-center gap-3 sm:gap-5">
                      <div class="group">
                          <span class="group-has-[div]:hidden flex shrink-0 justify-center items-center size-20 border-2 border-dotted border-gray-300 text-gray-400 cursor-pointer rounded-full hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-600 dark:hover:bg-neutral-700/50" style="height: 60px; width: 60px" data-trigger="avatar-preview">
                            @if ($avatar)
                              <img src="{{ $avatar->temporaryUrl() }}" class="w-full rounded-full object-cover" style="width: 100%; height: 100%" />
                            
                            @else
                            <svg class="shrink-0 size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                              <circle cx="12" cy="12" r="10"></circle>
                              <circle cx="12" cy="10" r="3"></circle>
                              <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                            </svg>
                            @endif
                            
                            
                          </span>
                        </div>

                        <div class="grow">
                          <div class="flex flex-center gap-x-2">
                              <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" data-trigger="upload-avatar">
                                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                                  </svg>
                                  Upload profile photo
                                </button>
                                <input type="file" class="hidden" id="avatar" accept="image/*">
                                @error('avatar') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                          </div>
                        </div>
                  </div>
              </div>
              </div>
              @endif

              @if($baseType == 'cover')
                
              <div class="mb-4 w-full flex justify-center items-center">
                <div class="cover">
                  <div id="cover-preview" data-trigger="cover-preview">
                    @if($cover)
                      <img src="{{ $cover->temporaryUrl() }}">
                    @else
                      <img src="/images/cover.jpg"> 
                    @endif
                    
                  </div>  
                  <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-500 bg-white text-black hover:bg-white-700 focus:outline-none focus:bg-white disabled:opacity-50 disabled:pointer-events-none upload-cover" data-trigger="upload-cover">
                      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" x2="12" y1="3" y2="15"></line>
                      </svg>
                      Upload cover photo
                    </button>
                    <input type="file" wire:model="cover" class="hidden" id="coverImage"> 
                    @error('cover') <span class="text-sm text-red-500">{{ $message }}</span> @enderror    
              </div>
              </div>
                 @endif 
                 
                 @if($baseType == 'gallery')
                 <div class="w-full flex justify-center items-center flex-col">
                    
                     <div class="gallery" data-trigger="gallery">
                         <h4>Click or drag and drop files here</h4>
                         
                         <button type="button" wire:click.prevent="$refs.galleryInput.click()" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-500 bg-white text-black hover:bg-white-700 focus:outline-none focus:bg-white disabled:opacity-50 disabled:pointer-events-none">
                             Upload gallery photos
                         </button>
                         <input type="file" wire:model="gallery" multiple class="hidden" id="galleryInput" accept="image/*">
                     </div>
             
                     
                     <div class="gallery-thumbnails">
                         @foreach ($tempGallery as $image)
                             <img src="{{ $image->temporaryUrl() }}" class="thumbnail">
                         @endforeach
                     </div>
             
                     <!-- Livewire Error Handling -->
                     @error('gallery.*') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                 </div>
             @endif
             
                 @switch($fieldType)
                  @case('avatar')
                     
                      @break

                  @case('cover')
                      
                      @break

                  @case('gallery')
                     
                      @break

                  @default
                      <label for="{{ $fieldName }}" class="block text-sm font-medium text-gray-700 capitalize mb-3">
                          {{ str_replace('_', ' ', $fieldName) }}
                      </label>
              @endswitch

                  
                  @error('formData.' . $fieldName) 
                    <span class="text-red-500">{{ $message }}</span>
                  @enderror
                  @if (Str::contains($fieldType, 'string') || Str::contains($fieldType, 'text'))
                      <input type="text" wire:model.defer="formData.{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                  @elseif (Str::contains($fieldType, 'email'))
                      <input type="email" wire:model.defer="formData.{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                  @elseif (Str::contains($fieldType, 'tel'))
                      <input type="tel" wire:model.defer="formData.{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                  @elseif (Str::contains($fieldType, 'url'))
                      <input type="url" wire:model.defer="formData.{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                  
                  @endif
          
      </div>
  @endforeach
          @if(session()->has('error'))
            <span class="text-red-500">{{session('error')}}</span>
          @endif
        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i wire:loading='inline' class="fas fa-spinner fa-spin"></i>
            <span wire:loading.remove>Save</span>
        </button>
    </form>
</div>

