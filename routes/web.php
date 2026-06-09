<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReciterController;
use App\Http\Controllers\Admin\TelaawahController;
use App\Http\Controllers\SheikhController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SheikhController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
});

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::controller(App\Http\Controllers\SocialiteController::class)->group(function () {
    Route::get('/auth/redirect/{provider}', 'redirect')->name('auth.redirect');
    Route::get('/auth/callback/{provider}', 'callback')->name('auth .callback');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('reciters', ReciterController::class);
    Route::resource('telaawat', TelaawahController::class)->except('show');
    Route::get('telaawat/bulk-upload', [TelaawahController::class, 'bulkUpload'])->name('telaawat.bulk-upload');
    Route::post('telaawat/bulk-store', [TelaawahController::class, 'bulkStore'])->name('telaawat.bulk-store');
});