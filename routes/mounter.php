<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('mounter.montages');
});

Route::get('/montages', [App\Http\Controllers\MontageController::class, 'index'])->name('mounter.montages');
Route::get('/process', [App\Http\Controllers\MontageController::class, 'process'])->name('mounter.process');
Route::get('/cancelled', [App\Http\Controllers\MontageController::class, 'cancelled'])->name('mounter.cancelled');

Route::post('/project/open', [App\Http\Controllers\MontageController::class, 'open'])->name('mounter.project.open');
Route::post('/montages/{montage}/upload', [App\Http\Controllers\MontageController::class, 'upload'])->name('mounter.montage.upload');
Route::get('/montages/{montage}/show', [App\Http\Controllers\MontageController::class, 'show'])->name('mounter.montage.show');
