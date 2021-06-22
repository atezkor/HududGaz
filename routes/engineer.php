<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('engineer.projects');
});

Route::get('projects', [App\Http\Controllers\EngineerController::class, 'projects'])->name('engineer.projects');
Route::get('montages', [App\Http\Controllers\EngineerController::class, 'montages'])->name('engineer.montages');
Route::get('permits', [App\Http\Controllers\EngineerController::class, 'permits'])->name('engineer.permits');
Route::get('permits/{permit}/show', [App\Http\Controllers\EngineerController::class, 'show'])->name('engineer.permit.show');
Route::get('projects/completed', [App\Http\Controllers\EngineerController::class, 'completedProjects'])->name('engineer.projects.archive');
Route::get('montages/completed', [App\Http\Controllers\EngineerController::class, 'archiveMontages'])->name('engineer.montages.archive');

Route::post('projects/{project}/confirm', [App\Http\Controllers\EngineerController::class, 'project'])->name('engineer.project.confirm');
Route::post('projects/{project}/cancel', [App\Http\Controllers\EngineerController::class, 'project'])->name('engineer.project.cancel');
Route::post('montages/{montage}/confirm', [App\Http\Controllers\EngineerController::class, 'montage'])->name('engineer.montage.confirm');
Route::post('montages/{montage}/cancel', [App\Http\Controllers\EngineerController::class, 'montage'])->name('engineer.montage.cancel');
Route::post('permits/{permit}/upload', [App\Http\Controllers\EngineerController::class, 'upload'])->name('engineer.permit.upload');
