<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
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
    resource('users', UserController::class, 'admin.users');
    resource('equipments', EquipmentController::class, 'admin.equipments');
    resource('designers', UserController::class, 'admin.designers');
    resource('mounters', UserController::class, 'admin.mounters');
    resource('regions', UserController::class, 'admin.regions');
    resource('statuses', UserController::class, 'admin.statuses');
    resource('activity-types', UserController::class, 'admin.activities');

    Route::get('equipment-types', [EquipmentController::class, 'show'])->name('admin.equipment_type');
    Route::get('timetable', [UserController::class, 'admin.timetable'])->name('admin.timetable');
    Route::get('settings', [UserController::class, 'admin.settings'])->name('admin.settings');
});

# main route - in route distribution by to roles
Route::get('/', function() {
    if (auth()->user() == null)
        return redirect()->route('login');

    return redirect()->route('admin.users.index');
})->name('dashboard');
