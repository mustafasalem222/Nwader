<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\TelaawahController;
use Illuminate\Support\Facades\Route;

Route::get('/telaawat/{telaawah}', [TelaawahController::class, 'show'])->name('telaawah.show');

Route::get('/telaawat/{telaawah}/download', [DownloadController::class, 'download'])->name('telaawat.download');
