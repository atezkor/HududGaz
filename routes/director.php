<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    //    return redirect()->route('director.index');
    return redirect()->route('director.users');
});

Route::get('statistics', [App\Http\Controllers\DirectorController::class, 'index'])->name('director.index');

// Users
Route::get('users', [App\Http\Controllers\UserController::class, 'director'])->name('director.users');
Route::get('organs', [App\Http\Controllers\OrganController::class, 'director'])->name('director.organs');
Route::get('designers', [App\Http\Controllers\DesignerController::class, 'director'])->name('director.designers');
Route::get('installers', [App\Http\Controllers\MounterController::class, 'director'])->name('director.installers');

// Documents
Route::get('propositions', [App\Http\Controllers\PropositionController::class, 'all'])->name('director.propositions');
Route::get('recommendations', [App\Http\Controllers\RecommendationController::class, 'director'])->name('director.recommendations');
Route::get('tech-conditions', [App\Http\Controllers\TechnicConditionController::class, 'director'])->name('director.tech_conditions');
Route::get('projects', [App\Http\Controllers\ProjectController::class, 'director'])->name('director.projects');
Route::get('montages', [App\Http\Controllers\MontageController::class, 'director'])->name('director.montages');
Route::get('permits', [App\Http\Controllers\DirectorController::class, 'permits'])->name('director.permits');
