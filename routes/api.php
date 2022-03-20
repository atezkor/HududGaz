<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;


Route::middleware('auth:sanctum')->group(function() {
    Route::post('/designer/project/create', [ProjectController::class, 'create'])->name('designer.project.create_api');
});

Route::any('/{any?}', function() {
    return response()->json([
        'msg' => "Kirishga ruxsat yo\u{2018}q"
    ]);
})->name('api');
