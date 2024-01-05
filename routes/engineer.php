<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('engineer.projects');
});

// TechCondition
Route::get('tech-conditions/{condition}/view', [App\Http\Controllers\TechnicConditionController::class, 'show'])->name('engineer.tech-condition.view');

// Projects
Route::get('projects', [App\Http\Controllers\ProjectController::class, 'engineer'])->name('engineer.projects');
Route::get('projects/{project}/view', [App\Http\Controllers\ProjectController::class, 'show'])->name('engineer.project.view');
Route::post('projects/{project}/confirm', [App\Http\Controllers\ProjectController::class, 'accept'])->name('engineer.project.confirm');
Route::post('projects/{project}/cancel', [App\Http\Controllers\ProjectController::class, 'reject'])->name('engineer.project.cancel');

// Montages
Route::get('montages', [App\Http\Controllers\MontageController::class, 'engineer'])->name('engineer.montages');
Route::get('montages/{montage}/view', [App\Http\Controllers\MontageController::class, 'show'])->name('engineer.montage.view');
Route::post('montages/{montage}/confirm', [App\Http\Controllers\MontageController::class, 'confirm'])->name('engineer.montage.confirm');
Route::post('montages/{montage}/reject', [App\Http\Controllers\MontageController::class, 'reject'])->name('engineer.montage.reject');

// Permits
Route::post('permits/{permit}/upload', [App\Http\Controllers\LicenseController::class, 'upload'])->name('engineer.permit.upload');
Route::get('permits', [App\Http\Controllers\LicenseController::class, 'index'])->name('engineer.permits');
Route::get('permits/{permit}/show', [App\Http\Controllers\LicenseController::class, 'show'])->name('engineer.permit.show');

// Archive
Route::get('projects/completed', [App\Http\Controllers\ProjectController::class, 'completed'])->name('engineer.projects.archive');
Route::get('montages/completed', [App\Http\Controllers\MontageController::class, 'completed'])->name('engineer.montages.archive');
