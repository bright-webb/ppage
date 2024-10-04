@extends('layout.app');
@section('content')
    @extends('partials.app')

    @section('main')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md" wire:id="template-form">
        <h3 class="text-xl font-bold mb-4">{{ $template->name }}</h3>
        <div class="divider mb-4"></div>
        
        <form id="templateForm" action="/post/doTemplateSave" method="post" enctype="multipart/form-data">
          <input type="hidden" name="templateId" value="{{ $template->id }}">
          @php
              $data = array_filter($schema, fn($fieldType) => !is_array($fieldType));
              $catalogSchema = array_filter($schema, fn($fieldType) => is_array($fieldType));
              
          @endphp
          @foreach ($data as $fieldName => $fieldType)
          
            @php
           
            $fieldParts = explode('|', $fieldType);
            $baseType = $fieldParts[0];
            $required = null;
            if(isset($fieldParts[1])){
               if($fieldParts[1] == 'required'){
                $required = 'required';
               }
                $required = $fieldParts[1];
            }
          
           if(isset($fieldParts[1]) && Str::contains($fieldParts[1], 'ext')){
             $extensions = explode(':', $fieldParts[1]);
             // Remove first item from the array
             $extensions = array_pop($extensions);
             if(gettype($extensions) == 'array' && count($extensions) > 0){
              $extensions = implode(',', array_map(function($ext){
                return '.' . $ext;
              }, $extension));
             }
             $extensions = '.'.$extensions;
            
             $videoField = strtolower($fieldName) == 'video' ? 'video' : '';
           }

            if($baseType === 'array'){
              $fieldType = 'array';
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
                               
                                <svg class="shrink-0 size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                  <circle cx="12" cy="12" r="10"></circle>
                                  <circle cx="12" cy="10" r="3"></circle>
                                  <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                                </svg>
                                
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
                                    <input type="file" class="hidden" name="{{$fieldName}}" id="avatar" accept="image/*">
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
                          <img src="/images/cover.jpg"> 
                      </div>  
                      <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-500 bg-white text-black hover:bg-white-700 focus:outline-none focus:bg-white disabled:opacity-50 disabled:pointer-events-none upload-cover" data-trigger="upload-cover">
                          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" x2="12" y1="3" y2="15"></line>
                          </svg>
                          Upload cover photo
                        </button>
                        <input type="file" name="{{$fieldName}}" class="hidden" id="coverImage"> 
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
                         </div>
                         
                         
                         <div class="gallery-thumbnails">
                            
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
                      
                      @case('array')

                        @break;
    
                      @default
                          <label for="{{ $fieldName }}" class="block text-sm font-medium text-gray-700 capitalize mb-3">
                              {{ str_replace('_', ' ', $fieldName) }}
                          </label>
                  @endswitch
    
                      
                      @error('formData.' . $fieldName) 
                        <span class="text-red-500">{{ $message }}</span>
                      @enderror
                      @if (Str::contains($fieldType, 'string') || Str::contains($fieldType, 'text'))
                          <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                      @elseif(Str::contains($fieldType, 'file'))
                      
                        <label for="file-input" class="sr-only">Choose file</label>
                       <div style="width: 100%">
                        <input type="file" name="{{$fieldName}}[]" id="file-input" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                        file:bg-gray-50 file:border-0
                        file:me-4
                        file:py-3 file:px-4
                        dark:file:bg-neutral-700 dark:file:text-neutral-400" accept="{{$extensions}}">
                    
                        <span class="text-gray-500 text-small">Supported extensions: {{$extensions}}</span>
                       </div>
                      @elseif (Str::contains($fieldType, 'email'))
                          <input type="email" name="{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                      @elseif (Str::contains($fieldType, 'tel'))
                          <input type="tel" name="{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                      @elseif (Str::contains($fieldType, 'url'))
                          <input type="url" name="{{ $fieldName }}" id="{{ $fieldName }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                      @elseif(Str::contains($fieldType, 'array'))

                      <div class="array">
                        <label>{{ str_replace('_', ' ', $fieldName) }}</label>
                        <div class="array-items">
                          
                            <label for="hs-trailing-button-add-on" class="sr-only">Label</label>
                            <div class="flex rounded-lg shadow-sm array-item">
                              <input type="url" name="{{ $fieldName }}[]" id="hs-trailing-button-add-on" name="hs-trailing-button-add-on" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $fieldName) }}" {{$required}}>
                            </div>
                          
                        </div>
                        <div class="mt-2">
                          <button type="button" class="add-array-item bg-blue-500 hover:bg-blue-700 text-white font-bold btn-sm py-2 px-4 rounded">Add</button>
                        </div>
                      </div>
                      @endif
              
          </div>
      @endforeach

      @if(count($catalogSchema) > 0)
    @foreach($catalogSchema as $fieldName => $fields)
    <div>
        <h4 class="text-gray-500">{{ucwords($fieldName)}}</h4>
        <div class="divider"></div>
    </div>
    <div class="catalog-container mb-4 border border-gray-500 rounded-lg px-4 py-4">
        <!-- This is the original input set that will be cloned -->
        <div class="catalog-input-set" data-index="0">
            @foreach($fields as $key => $field)
                @php
                    $parts = strpos('|', $field) !== false ? explode('|', $field) : [$field];
                    $required = in_array('required', $parts) ? 'required' : '';
                    $type = $parts[0];
                @endphp
                <div class="mb-4">
                    <label for="{{ $key }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                    @if(Str::contains($type, 'image'))
                        <input type="file" name="catalog_{{ $key }}[]" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400" accept="image/*" {{$required}}>
                    @elseif(Str::contains($type, 'number'))
                        <input type="number" name="catalog_{{ $key }}[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $key) }}" {{$required}}>
                    @elseif(Str::contains($type, 'price'))
                        <div class="relative" style="width: 100%">
                            <input type="text" id="hs-input-with-leading-and-trailing-icon" name="catalog_{{$key}}[]" class="py-3 px-4 ps-9 pe-16 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="0.00">
                            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-4">
                                <span class="text-gray-500 dark:text-neutral-500">USD</span>
                            </div>
                        </div>
                    @else
                        <input type="text" name="catalog_{{ $key }}[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" placeholder="Enter {{ str_replace('_', ' ', $key) }}" {{$required}}>
                    @endif
                </div>
            @endforeach
            <button type="button" class="remove-catalog hidden inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-small text-white bg-red-600 hover:bg-red-500 rounded-lg">Remove</button>
        </div>
    </div>
    <button type="button" class="add-catalog inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-small text-white bg-green-950 hover:bg-green-500 rounded-lg">Add</button>
    @endforeach
@endif
            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save
            </button>
        </form>
    </div>
    
    
    @endsection
@endsection