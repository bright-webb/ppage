@extends('layout.app');
@section('content')
    @extends('partials.app')

    @section('main')
        @if(isset($template) > 0)
        <div class="container">
            <div class="row d-flex justify-center">
                <h4 class="text-gray-500 text-xl">{{$template->name}}</h4>
                <div class="divider"></div>
                <div class="mt-4"></div>
                <div class="col-md-5">
                    <img class="w-100 sm:w-100 h-full inset-0 object-cover rounded-s-lg" src="{{ asset(Storage::url($template->thumbnail)) }}"alt="Thumbnail">
                </div>
                <div class="col-md-6">
                    <h4 class="text-base">{{$template->description}}</h4>
                    <div class="mt-4"></div>
                    <a href="/form/template/{{$template->id}}" class="py-3 px-5 inline-flex items-center gap-x2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                        <span>Apply</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="flex justify-center items-center min-h-screen bg-gray-100">
            <div class="max-w-sm w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 mb-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">No Templates Found</h3>
                    <p class="text-gray-600 mt-2 text-center">It looks like you don't have any templates yet. Start by creating a new template.</p>
                    <a href="/templates" class="mt-6 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Choose Template
                    </a>
                </div>
            </div>
        </div>
        @endif
    @endsection
@endsection