<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [GoogleAuthController::class, GoogleAuthController::REDIRECT])->name('login');
    Route::get('/logincallback', [GoogleAuthController::class, GoogleAuthController::HANDLE_CALLBACK]);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [GoogleAuthController::class, GoogleAuthController::DESTROY])
        ->name('logout');
});
