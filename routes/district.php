<?php

use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::get('', function() {
    return redirect()->route('district.recommendations');
});
Route::get('propositions', [RecommendationController::class, 'index'])->name('district.propositions');
Route::get('recommendations', [RecommendationController::class, 'index'])->name('district.recommendations');
Route::get('recommendations/cancelled', [RecommendationController::class, 'index'])->name('district.recommendations.cancelled');
Route::get('recommendations/archive', [RecommendationController::class, 'index'])->name('district.recommendations.archive');

Route::get('recommendations/{proposition}/create/{type}', [RecommendationController::class, 'create'])->name('district.recommendation.create');
Route::post('recommendation/create/{type}', [RecommendationController::class, 'store'])->name('district.recommendation.store');
