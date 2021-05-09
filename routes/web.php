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
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');

# main route - in route distribution by to roles
Route::get('/', function () {
    if (auth()->user() == null)
        return redirect()->route('login');

//    $role_name = auth()->user()->getAuthPassword();

    return redirect()->route('admin.users');
//    return redirect()->route('login');
})->name('dashboard');
