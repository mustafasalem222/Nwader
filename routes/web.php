<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::prefix('auth')->name('auth.')->controller(SocialiteController::class)->group(function () {
    Route::get('/redirect/{provider}', 'redirect')->name('redirect');
    Route::get('/callback/{provider}', 'callback')->name('callback');
});