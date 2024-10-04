<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\SignUp;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\DeveloperController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function(){
    return view('welcome');
});


Route::middleware(['web'])->group(function () {
    Route::get('/login', function(){
        return view('/login');
    });
    
    Route::get('sign-up', function() {
        return view('/signup');
    });
    Route::get('forgot-password', function() {
        return view('/forgot-password');
    });
    
    Route::post('/api/do-login', [PostController::class, 'doLogin']);
    // Email verification
Route::get('/email/verify/{id}/{hash}', [HomeController::class, 'verify'])->name('verification.verify');


// Api Requests
Route::post('/api/do-signup', [PostController::class, 'doSignUp']);



});




Route::middleware(['web', 'auth'])->group(function(){
    Route::post('/post/doTemplateSave', [PostController::class, 'templateSave']);

    Route::get('/dashboard', [HomeController::class, 'dashboard']);
    Route::get('/profile', [HomeController::class, 'profile']);
    Route::get('/profile/new', [HomeController::class, 'newProfile']);
    Route::get('/card/new', [HomeController::class, 'newCard']);
    Route::get('/templates', [HomeController::class, 'templates']);
    Route::get('/{slug}/view', [HomeController::class, 'viewTemplate']);
    Route::get('/form/template/{id}', [HomeController::class, 'TemplateForm']);

    // Developer's portal
    Route::get('/account/developer', [DeveloperController::class, 'index']);
});

Route::get('/developer/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/email-verified-success');
})->middleware(['signed'])->name('verification.verify');

Route::get('/{username}', [HomeController::class, 'viewProfile']);




