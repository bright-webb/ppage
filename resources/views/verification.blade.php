@extends('layout.app');
@section('content')
<div class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Verify Your Email</h2>
        <p class="mb-4 text-center text-gray-600">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
        </p>
        @if (session('resent'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <p class="text-sm">A fresh verification link has been sent to your email address.</p>
            </div>
        @endif
        <form method="POST">
            @csrf
            <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Resend Verification Email
            </button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="font-medium text-gray-800 hover:text-gray-700">
                Log out
            </a>
        </p>
       
    </div>
</div>
@endsection