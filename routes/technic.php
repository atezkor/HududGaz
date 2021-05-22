<?php

use App\Http\Controllers\PropositionController;
use App\Http\Controllers\TechnicController;
use Illuminate\Support\Facades\Route;


Route::get('', function() {
    return redirect()->route('propositions.index');
});
resource('propositions', PropositionController::class, 'propositions');
Route::get('recommendations', [TechnicController::class, 'index'])->name('technic.recommendations');
