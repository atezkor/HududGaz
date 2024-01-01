<?php

use App\Http\Controllers\PropositionController;
use Illuminate\Support\Facades\Route;

Route::get('', function() {
    return redirect()->route('propositions.index');
});

Route::resource('propositions', PropositionController::class);
Route::get('propositions/check-for-tin/{type?}/{tin?}', [App\Http\Controllers\PropositionController::class, 'check'])->name('propositions.check-for-tin');
Route::get('propositions/check-for-pinfl/{type?}/{tin?}', [App\Http\Controllers\PropositionController::class, 'check'])->name('propositions.check-for-pin');
Route::get('propositions/{type?}/{tin?}', [App\Http\Controllers\PropositionController::class, 'exist'])->name('technic.propositions');

Route::get('recommendations', [App\Http\Controllers\RecommendationController::class, 'technic'])->name('technic.recommendations');
Route::get('recommendations/{recommendation}', [App\Http\Controllers\TechnicConditionController::class, 'show'])->name('technic.recommendation.show');
Route::post('recommendations/{recommendation}/back', [App\Http\Controllers\TechnicConditionController::class, 'back'])->name('technic.recommendation.back');

Route::get('recommendations/{recommendation}/create', [App\Http\Controllers\TechnicConditionController::class, 'create'])->name('technic.tech_condition.create');
Route::post('recommendation/{recommendation}/store', [App\Http\Controllers\TechnicConditionController::class, 'store'])->name('technic.tech_condition.store');
Route::get('tech-conditions', [App\Http\Controllers\TechnicConditionController::class, 'index'])->name('technic.index');
Route::get('tech-conditions/{condition}/edit', [App\Http\Controllers\TechnicConditionController::class, 'edit'])->name('technic.tech_condition.edit');
Route::post('tech-conditions/{condition}/update', [App\Http\Controllers\TechnicConditionController::class, 'update'])->name('technic.tech_condition.update');

Route::get('tech-conditions/{condition}/show', [App\Http\Controllers\TechnicConditionController::class, 'show_condition'])->name('technic.tech_condition.show');
Route::post('tech-conditions/{condition}/upload', [App\Http\Controllers\TechnicConditionController::class, 'upload'])->name('technic.tech_condition.upload');

Route::get('region-section', [App\Http\Controllers\TechnicConditionController::class, 'region'])->name('technic.reg_section');
Route::get('organ-section', [App\Http\Controllers\TechnicConditionController::class, 'organ'])->name('technic.org_section');
Route::get('detail', [App\Http\Controllers\TechnicConditionController::class, 'detail'])->name('technic.detail');
