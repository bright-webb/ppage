@extends('layout.app')
@section('content')
@include('partials.navbar')

<div class="flex justify-center items-center shadow-sm mt-10 mb-10">
    <div class="bg-white rounded-lg shadow-lg flex max-w-4xl w-full">
        <!-- Sign Up Form Side -->
        <div class="w-1/2 p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Create Account</h2>
            <form method="POST" action="/api/do-signup" id="submitSignUpForm">
               <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" required 
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required 
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required 
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                           class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                </div>
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="terms" required 
                               class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                        <span class="ml-2 block text-sm text-gray-900">
                            I agree to the <a href="#" class="text-gray-600 hover:text-gray-500">Terms and Conditions</a>
                        </span>
                    </label>
                </div>
                <div class="mb-6">
                    <div id="error" class="hidden bg-red-50 border-s-4 border-red-500 p-4 dark:bg-red-800/30" role="alert" tabindex="-1" aria-labelledby="hs-bordered-red-style-label">
                    <div class="flex">
                      <div class="shrink-0">
                        <!-- Icon -->
                        <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 dark:border-red-900 dark:bg-red-800 dark:text-red-400">
                          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                          </svg>
                        </span>
                        <!-- End Icon -->
                      </div>
                      <div class="ms-3">
                        <h3 id="hs-bordered-red-style-label" class="text-gray-800 font-semibold dark:text-white">
                          Error!
                        </h3>
                        <p class="message text-sm text-gray-700 dark:text-neutral-400">
                         
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                    <button type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Sign Up &nbsp;
                        <svg aria-hidden="true" role="status" class="hidden w-4 h-4 me-3 text-white spin animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                          </svg>
                    </button>
                </div>
                
            </form>
            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="/login" class="font-medium text-gray-800 hover:text-gray-700">
                    Log in
                </a>
            </p>
        </div>
        
        <!-- Image Side -->
        <div class="w-1/2 bg-gray-200 rounded-r-lg flex items-center justify-center">
            <img src="/images/2149132911.jpg" alt="Sign Up" class="object-cover h-full w-full rounded-r-lg">
        </div>
    </div>

</div>
    
@endsection