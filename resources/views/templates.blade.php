@extends('layout.app');
@section('content')
    @extends('partials.app')

    @section('main')
        @if(count($templates) > 0)
          <div class="container">
            <div class="row">
                @foreach($templates as $template)
                 <div class="col-md-6">
                    <a class="block border border-gray-200 rounded-lg hover:shadow-sm focus:outline-none dark:border-neutral-700" href="{{$template->slug}}/view">
                        <div class="relative flex items-center overflow">
                        <img class="w-32 sm:w-48 h-full absolute inset-0 object-cover rounded-s-lg" src="{{ asset(Storage::url($template->thumbnail)) }}"alt="Thumbnail">
                        <div class="grow p-4 ms-32 sm:ms-48">
                            <div class="min-h-24 flex flex-col justify-center">
                                <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-300">
                                    {{$template->name}}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-neutral-500">
                                    {{$template->description}}
                                    </p>
                            </div>
                        </div>
                        </div>
                    </a>
                 </div>
               @endforeach
            </div>
          </div>
        @else 
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">No templates found!</h4>
            </div>
        @endif
    @endsection
@endsection