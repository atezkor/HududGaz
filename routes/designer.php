<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('designer.projects');
});

// TechCondition
Route::get('tech-conditions/{condition}/view', [App\Http\Controllers\TechnicConditionController::class, 'show'])->name('designer.tech-condition.view');

// Project
Route::get('projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('designer.projects');
Route::post('projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('designer.project.create');
Route::get('process', [App\Http\Controllers\ProjectController::class, 'process'])->name('designer.projects.process');
Route::get('cancelled', [App\Http\Controllers\ProjectController::class, 'cancelled'])->name('designer.projects.cancelled');
Route::get('completed', [App\Http\Controllers\ProjectController::class, 'archive'])->name('designer.projects.accomplished');

Route::get('projects/{project}/view', [App\Http\Controllers\ProjectController::class, 'show'])->name('designer.project.view');
Route::post('projects/{project}/finish', [App\Http\Controllers\ProjectController::class, 'update'])->name('designer.project.finish');
Route::post('project/delete/{project?}', [App\Http\Controllers\ProjectController::class, 'delete'])->name('designer.project.delete');

