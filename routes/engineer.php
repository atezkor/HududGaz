<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('engineer.projects');
});

Route::get('projects', [App\Http\Controllers\EngineerController::class, 'projects'])->name('engineer.projects');
Route::get('montages', [App\Http\Controllers\EngineerController::class, 'montages'])->name('engineer.montages');
Route::post('projects/{project}/confirm', [App\Http\Controllers\EngineerController::class, 'confirm'])->name('engineer.project.confirm');
Route::post('projects/{project}/cancel', [App\Http\Controllers\EngineerController::class, 'cancel'])->name('engineer.project.cancel');
