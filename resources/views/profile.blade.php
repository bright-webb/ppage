@extends('layout.app');
@section('content')
    @extends('partials.app')

    @section('main')
        @if(!empty($data))
            @livewire('profile-form', ['id' => Session::get('user')])
        @else
        <div class="flex justify-center py-4">
            <div class="max-w-md w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <!-- Icon or Illustration -->
                <div class="flex flex-col items-center mb-4">
                    <svg class="w-20 h-20 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                
                <!-- Text Content -->
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Your Profile is Empty</h2>
                    <p class="text-gray-600">Looks like you haven't set up your profile yet. Get started by creating a quick profile or select template.</p>
                </div>
        
                <!-- Action Buttons -->
                <div class="mt-6 flex justify-center space-x-4">
                    <a href="/profile/new" class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Quick Profile
                    </a>
                    <a href="#" class="inline-block px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Browse Templates
                    </a>
                </div>
            </div>
        </div>
        
        @endif
    @endsection
@endsection
