<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('loginPost');
Route::get('/reg', [AuthController::class, 'regPage'])->name('regGet');
Route::post('/reg', [AuthController::class, 'Registration'])->name('regPost');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::group(['prefix' => 'admin'], function() {
    Route::get('/', function() {return redirect('/');});
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/equipments', [UserController::class, 'index'])->name('admin.equipments');
    Route::get('/designers', [UserController::class, 'index'])->name('admin.designers');
    Route::get('/mounters', [UserController::class, 'index'])->name('admin.mounters');
    Route::get('/settings', [UserController::class, 'index'])->name('admin.settings');
    Route::get('/regions', [UserController::class, 'index'])->name('admin.regions');
    Route::get('/statuses', [UserController::class, 'index'])->name('admin.statuses');
    Route::get('/activity-type', [UserController::class, 'index'])->name('admin.activities');
    Route::get('/timetable', [UserController::class, 'index'])->name('admin.timetable');
});

# main route - in route distribution by to roles
Route::get('/', function() {
    if (auth()->user() == null)
        return redirect()->route('login');

    return redirect()->route('admin.users');
})->name('dashboard');
