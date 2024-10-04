@php
  if(!Session::get('user')){
    print("Redirect");
    print("<script>window.location.href='/login'</script>");
    return;
  }
@endphp
<!-- ========== HEADER ========== -->
<header class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 lg:ps-[260px] dark:bg-neutral-800 dark:border-neutral-700">
    <nav class="px-4 sm:px-6 flex basis-full items-center w-full mx-auto" style="margin-top: -20px">
      <div class="me-5 lg:me-0 lg:hidden">
        <!-- Logo -->
        <a class="flex-none rounded-md text-xl inline-block font-semibold focus:outline-none focus:opacity-80 logo" href="#" aria-label="Preline">
         <img src="/images/ppage.png" alt="logo" class="logo">
        </a>
        <!-- End Logo -->
      </div>
  
      <div class="w-full flex items-center justify-end ms-auto md:justify-between gap-x-1 md:gap-x-3">
  
        <div class="hidden md:block">
         
        </div>
  
        <div class="flex flex-row items-center justify-end gap-1">
          <ul class="flex space-x-2">
            <li>
                <a href="/profile"><i class="fas fa-user"></i> profile</a>
            </li>
            <li>
              <a href="/account/developer"><i class="fas fa-code"></i> Developer </a>
            </li>
            <li>
                <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!-- ========== END HEADER ========== -->
  
  <!-- ========== MAIN CONTENT ========== -->
  <div class="-mt-px">
    <!-- Breadcrumb -->
    <div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 lg:px-8 lg:hidden dark:bg-neutral-800 dark:border-neutral-700">
      <div class="flex items-center py-2">
        <!-- Navigation Toggle -->
        <button type="button" class="size-8 flex justify-center items-center gap-x-2 border border-gray-200 text-gray-800 hover:text-gray-500 rounded-lg focus:outline-none focus:text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar" aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
          <span class="sr-only">Toggle Navigation</span>
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m8 9 3 3-3 3"/></svg>
        </button>
        <!-- End Navigation Toggle -->
  
        <!-- Breadcrumb -->
        <ol class="ms-3 flex items-center whitespace-nowrap">
          <li class="text-sm font-semibold text-gray-800 truncate dark:text-neutral-400" aria-current="page">
            Dashboard
          </li>
        </ol>
        <!-- End Breadcrumb -->
      </div>
    </div>
    <!-- End Breadcrumb -->
  </div>
  
  <!-- Sidebar -->
  <div id="hs-application-sidebar" class="hs-overlay  [--auto-close:lg]
    hs-overlay-open:translate-x-0
    -translate-x-full transition-all duration-300 transform
    w-[260px] h-full
    hidden
    fixed inset-y-0 start-0 z-[60]
    bg-white border-e border-gray-200
    lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
    dark:bg-neutral-800 dark:border-neutral-700" role="dialog" tabindex="-1" aria-label="Sidebar">
    <div class="relative flex flex-col h-full max-h-full">
      <div class="px-6 pt-4">
        <!-- Logo -->
        <a class="logo" href="#" aria-label="Logo">
          <img src="/images/ppage.png" alt="logo" class="logo">
        </a>
        <!-- End Logo -->
      </div>
  
      <!-- Content -->
      <div class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
          <ul class="flex flex-col space-y-1">
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-white {{ request()->is('/dashboard') ? 'bg-gray-100 dark:bg-neutral-700' : 'dark:bg-neutral-800 dark:hover:bg-neutral-700' }}" href="/dashboard">
                    Dashboard
                </a>
            </li>
        
            <li class="hs-accordion" id="users-accordion">
                <a href="/card/new" class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-200 {{ request()->is('card/new') ? 'bg-gray-100 dark:bg-neutral-700' : 'dark:bg-neutral-800 dark:hover:bg-neutral-700' }}" aria-expanded="true" aria-controls="users-accordion-child">
                    Create new card
                </a>
            </li>
        
            <li class="hs-accordion" id="account-accordion">
                <a href="/templates" class="w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-200 {{ request()->is('templates') ? 'bg-gray-100 dark:bg-neutral-700' : 'dark:bg-neutral-800 dark:hover:bg-neutral-700' }}" aria-expanded="true">
                    Templates
                </a>        
            </li>
        </ul>
        </nav>
      </div>
      <!-- End Content -->
    </div>
  </div>
  <!-- End Sidebar -->
  
  <!-- Content -->
  <div class="w-full lg:ps-64">
    <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
      @yield('main')
    </div>
  </div>
  <!-- End Content -->
  <!-- ========== END MAIN CONTENT ========== -->