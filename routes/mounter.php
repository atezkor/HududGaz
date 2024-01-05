<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('mounter.montages');
});

Route::get('montages', [App\Http\Controllers\MontageController::class, 'index'])->name('mounter.montages');
Route::get('process', [App\Http\Controllers\MontageController::class, 'process'])->name('mounter.process');
Route::get('cancelled', [App\Http\Controllers\MontageController::class, 'cancelled'])->name('mounter.cancelled');
Route::get('archive', [App\Http\Controllers\MontageController::class, 'archive'])->name('mounter.archive');

// TechCondition
Route::get('tech-conditions/{condition}/view', [App\Http\Controllers\TechnicConditionController::class, 'show'])->name('mounter.tech-condition.view');

// Project
Route::get('projects/{project}/view', [App\Http\Controllers\ProjectController::class, 'show'])->name('mounter.project.view');

Route::post('project/open', [App\Http\Controllers\MontageController::class, 'store'])->name('mounter.project.open');
Route::post('montages/{montage}/complete', [App\Http\Controllers\MontageController::class, 'update'])->name('mounter.montage.finish');
Route::get('montages/{montage}/view', [App\Http\Controllers\MontageController::class, 'show'])->name('mounter.montage.view');
Route::post('montage/delete/{montage?}', [App\Http\Controllers\MontageController::class, 'delete'])->name('mounter.montage.delete');
