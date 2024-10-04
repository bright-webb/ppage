@extends('layout.app')
@section('content')
@include('partials.navbar')
   <div style="margin-top: 50px">
    <div class="flex justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Reset Password</h2>
            <form method="POST" action="#">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required 
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                </div>
                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Send Password Reset Link
                    </button>
                </div>
            </form>
            <p class="mt-6 text-center text-sm text-gray-600">
                Remember your password?
                <a href="/login" class="font-medium text-gray-800 hover:text-gray-700">
                    Log in
                </a>
            </p>
        </div>
    </div>
   </div>
@endsection