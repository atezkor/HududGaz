<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('mounter.montages');
});

Route::get('/montages', [App\Http\Controllers\MontageController::class, 'index'])->name('mounter.montages');
Route::get('/progress', [App\Http\Controllers\MontageController::class, 'index'])->name('mounter.progress');
Route::get('/cancelled', [App\Http\Controllers\MontageController::class, 'index'])->name('mounter.cancelled');
Route::post('/project/open', [App\Http\Controllers\MontageController::class, 'open'])->name('mounter.project.open');
