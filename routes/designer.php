<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('designer.projects');
});

Route::get('projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('designer.projects');
Route::get('progress', [App\Http\Controllers\ProjectController::class, 'progress'])->name('designer.projects.progress');
Route::get('cancelled', [App\Http\Controllers\ProjectController::class, 'cancelled'])->name('designer.projects.cancelled');

Route::post('project/add', [App\Http\Controllers\ProjectController::class, 'add'])->name('designer.project.add');
Route::post('projects/{project}/upload', [App\Http\Controllers\ProjectController::class, 'upload'])->name('designer.project.upload');

