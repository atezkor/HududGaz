<?php

use Illuminate\Support\Facades\Route;

Route::get('', function() {
    return redirect()->route('propositions.index');
});
resource('propositions', App\Http\Controllers\PropositionController::class, 'propositions');
Route::get('recommendations', [App\Http\Controllers\TechnicController::class, 'recommendations'])->name('technic.recommendations');
Route::get('recommendations/{recommendation}', [App\Http\Controllers\TechnicController::class, 'show'])->name('technic.recommendation.show');
Route::post('recommendations/{recommendation}/back', [App\Http\Controllers\TechnicController::class, 'back'])->name('technic.recommendation.back');
