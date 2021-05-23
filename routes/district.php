<?php

use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::get('', function() {
    return redirect()->route('district.propositions');
});
Route::get('recommendations', [RecommendationController::class, 'index'])->name('district.recommendations');
Route::get('propositions', [RecommendationController::class, 'propositions'])->name('district.propositions');
Route::get('recommendations/progress', [RecommendationController::class, 'index'])->name('district.recommendations.progress');
Route::get('recommendations/cancelled', [RecommendationController::class, 'index'])->name('district.recommendations.cancelled');
Route::get('recommendations/archive', [RecommendationController::class, 'index'])->name('district.recommendations.archive');

Route::get('recommendations/{proposition}/create/{type}', [RecommendationController::class, 'create'])->name('district.recommendation.create');
Route::post('recommendation/create/{type}', [RecommendationController::class, 'store'])->name('district.recommendation.store');
Route::post('recommendations/{recommendation}/upload', [RecommendationController::class, 'upload'])->name('district.recommendation.upload');
Route::get('recommendations/{recommendation}', [RecommendationController::class, 'show'])->name('district.recommendation.show');
Route::get('propositions/{proposition}/show', [RecommendationController::class, 'proposition'])->name('district.proposition.show');
