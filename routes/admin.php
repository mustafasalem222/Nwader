<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReciterController;
use App\Http\Controllers\Admin\TelaawahController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('reciters', ReciterController::class);
    Route::resource('telaawat', TelaawahController::class)->except('show');
    Route::get('telaawat/bulk-upload', [TelaawahController::class, 'bulkUpload'])->name('telaawat.bulk-upload');
    Route::post('telaawat/bulk-store', [TelaawahController::class, 'bulkStore'])->name('telaawat.bulk-store');
});
