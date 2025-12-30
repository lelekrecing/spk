<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SpkController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('pelanggans.index'));

Route::resource('pelanggans', PelangganController::class);
Route::get('/spk', [SpkController::class, 'index'])->name('spk.index');
