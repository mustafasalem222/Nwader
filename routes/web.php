<?php

use App\Http\Controllers\SheikhController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SheikhController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::controller(App\Http\Controllers\SocialiteController::class)->group(function () {
    Route::get('/auth/redirect/{provider}', 'redirect')->name('auth.redirect');
    Route::get('/auth/callback/{provider}', 'callback')->name('auth .callback');
});
