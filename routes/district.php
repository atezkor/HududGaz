<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendationController;

Route::get('', function() {
    return redirect()->route('district.propositions');
});
Route::get('recommendations', [RecommendationController::class, 'index'])->name('district.recommendations');
Route::get('propositions', [RecommendationController::class, 'propositions'])->name('district.propositions');
Route::get('recommendations/progress', [RecommendationController::class, 'progress'])->name('district.recommendations.progress');
Route::get('recommendations/cancelled', [RecommendationController::class, 'cancelled'])->name('district.recommendations.cancelled');
Route::get('recommendations/archive', [RecommendationController::class, 'archives'])->name('district.recommendations.archive');

Route::get('recommendations/{proposition}/create/{type}', [RecommendationController::class, 'create'])->name('district.recommendation.create');
Route::post('recommendation/store/{type}', [RecommendationController::class, 'store'])->name('district.recommendation.store');
Route::post('recommendations/{recommendation}/upload', [RecommendationController::class, 'upload'])->name('district.recommendation.upload');
Route::get('recommendations/{recommendation}/edit', [RecommendationController::class, 'edit'])->name('district.recommendation.edit');
Route::post('recommendations/{recommendation}/update', [RecommendationController::class, 'update'])->name('district.recommendation.update');
Route::get('recommendations/{recommendation}', [RecommendationController::class, 'show'])->name('district.recommendation.show');
Route::get('propositions/{proposition}', [RecommendationController::class, 'proposition'])->name('district.proposition.show');
Route::get('add-equipment', [RecommendationController::class, 'add'])->name('district.equipment.add');
Route::get('add-type/{equipment?}', [RecommendationController::class, 'types'])->name('district.equipment.type');
