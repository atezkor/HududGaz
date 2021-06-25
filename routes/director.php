<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('director.users');
});

Route::get('users', [App\Http\Controllers\DirectorController::class, 'users'])->name('director.users');
Route::get('organs', [App\Http\Controllers\DirectorController::class, 'organs'])->name('director.organs');
Route::get('designers', [App\Http\Controllers\DirectorController::class, 'designers'])->name('director.designers');
Route::get('installers', [App\Http\Controllers\DirectorController::class, 'installers'])->name('director.installers');
Route::get('propositions', [App\Http\Controllers\DirectorController::class, 'propositions'])->name('director.propositions');
Route::get('recommendations', [App\Http\Controllers\DirectorController::class, 'recommendations'])->name('director.recommendations');
Route::get('tech-conditions', [App\Http\Controllers\DirectorController::class, 'tech_conditions'])->name('director.tech_conditions');
Route::get('projects', [App\Http\Controllers\DirectorController::class, 'projects'])->name('director.projects');
Route::get('montages', [App\Http\Controllers\DirectorController::class, 'montages'])->name('director.montages');
Route::get('permits', [App\Http\Controllers\DirectorController::class, 'permits'])->name('director.permits');
