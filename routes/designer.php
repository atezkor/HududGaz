<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('designer.projects');
});

Route::get('projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('designer.projects');
Route::post('projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('designer.project.create');
Route::get('process', [App\Http\Controllers\ProjectController::class, 'process'])->name('designer.projects.process');
Route::get('cancelled', [App\Http\Controllers\ProjectController::class, 'cancelled'])->name('designer.projects.cancelled');
Route::get('completed', [App\Http\Controllers\ProjectController::class, 'archive'])->name('designer.projects.accomplished');

Route::get('projects/{project}/show', [App\Http\Controllers\ProjectController::class, 'show'])->name('designer.project.show');
Route::post('projects/{project}/upload', [App\Http\Controllers\ProjectController::class, 'update'])->name('designer.project.upload');
Route::post('project/delete/{project?}', [App\Http\Controllers\ProjectController::class, 'delete'])->name('designer.project.delete');

