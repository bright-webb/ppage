<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/templates', [ApiController::class, 'getTemplates']);
Route::get('/form/{id}', [ApiController::class, 'getForm']);
Route::post('/submit', [ApiController::class, 'submit']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
