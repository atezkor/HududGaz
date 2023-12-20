<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\PropositionController;
use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::get('', function() {
    return redirect()->route('organ.propositions');
});
Route::get('propositions', [PropositionController::class, 'organ'])->name('organ.propositions');
Route::get('propositions/{proposition}', [PropositionController::class, 'view'])->name('organ.proposition.show');
Route::get('propositions/{proposition}/{type}', [PropositionController::class, 'statement'])->name('organ.statement.create');

Route::post('recommendations', [RecommendationController::class, 'store'])->name('organ.recommendation.store');
Route::get('recommendations', [RecommendationController::class, 'index'])->name('organ.recommendations');
Route::get('recommendations/progress', [RecommendationController::class, 'progress'])->name('organ.recommendations.progress');
Route::get('recommendations/cancelled', [RecommendationController::class, 'cancelled'])->name('organ.recommendations.cancelled');
Route::get('recommendations/archive', [RecommendationController::class, 'archives'])->name('organ.recommendations.archive');

Route::post('recommendations/{recommendation}/upload', [RecommendationController::class, 'upload'])->name('organ.recommendation.upload');
Route::get('recommendations/{recommendation}/edit', [RecommendationController::class, 'edit'])->name('organ.recommendation.edit');
Route::post('recommendations/{recommendation}/update', [RecommendationController::class, 'update'])->name('organ.recommendation.update');
Route::get('recommendations/{recommendation}', [RecommendationController::class, 'show'])->name('organ.recommendation.show');

Route::get('equipment-types-list', [EquipmentController::class, 'types'])->name('organ.equipment.types');
Route::get('equipment-list/{equipment?}', [EquipmentController::class, 'list'])->name('organ.equipment.list');
