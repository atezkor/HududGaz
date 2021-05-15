<?php

use App\Http\Controllers\PropositionController;
use Illuminate\Support\Facades\Route;


Route::get('', function() {
    return redirect()->route('propositions.index');
});
resource('propositions', PropositionController::class, 'propositions');
