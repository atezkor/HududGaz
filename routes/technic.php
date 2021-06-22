<?php

use Illuminate\Support\Facades\Route;

Route::get('', function() {
    return redirect()->route('propositions.index');
});
resource('propositions', App\Http\Controllers\PropositionController::class, 'propositions');
Route::get('recommendations', [App\Http\Controllers\TechnicController::class, 'recommendations'])->name('technic.recommendations');
Route::get('recommendations/{recommendation}', [App\Http\Controllers\TechnicController::class, 'show'])->name('technic.recommendation.show');
Route::post('recommendations/{recommendation}/back', [App\Http\Controllers\TechnicController::class, 'back'])->name('technic.recommendation.back');

Route::get('tech-conditions', [App\Http\Controllers\TechnicController::class, 'index'])->name('technic.index');
Route::get('recommendations/{recommendation}/create', [App\Http\Controllers\TechnicController::class, 'create'])->name('technic.tech_condition.create');
Route::post('recommendation/{recommendation}/store', [App\Http\Controllers\TechnicController::class, 'store'])->name('technic.tech_condition.store');
Route::get('recommendations/{recommendation}/edit', [App\Http\Controllers\TechnicController::class, 'edit'])->name('technic.tech_condition.edit');
Route::post('recommendations/{recommendation}/update', [App\Http\Controllers\TechnicController::class, 'update'])->name('technic.tech_condition.update');

Route::get('tech-conditions/{condition}/show', [App\Http\Controllers\TechnicController::class, 'show_condition'])->name('technic.tech_condition.show');
Route::post('tech-conditions/{condition}/upload', [App\Http\Controllers\TechnicController::class, 'upload'])->name('technic.tech_condition.upload');

Route::get('region-section', [App\Http\Controllers\TechnicController::class, 'region'])->name('technic.reg_section');
Route::get('organ-section', [App\Http\Controllers\TechnicController::class, 'organ'])->name('technic.org_section');
Route::get('more', [App\Http\Controllers\TechnicController::class, 'more'])->name('technic.more');
