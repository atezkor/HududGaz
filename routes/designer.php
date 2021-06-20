<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('designer.projects');
});

Route::get('projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('designer.projects');
Route::get('process', [App\Http\Controllers\ProjectController::class, 'process'])->name('designer.projects.process');
Route::get('cancelled', [App\Http\Controllers\ProjectController::class, 'cancelled'])->name('designer.projects.cancelled');

Route::post('project/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('designer.project.create');
Route::post('projects/{project}/upload', [App\Http\Controllers\ProjectController::class, 'upload'])->name('designer.project.upload');
Route::get('projects/{project}/show', [App\Http\Controllers\ProjectController::class, 'show'])->name('designer.project.show');

