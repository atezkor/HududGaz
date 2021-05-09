<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('loginPost');
Route::get('/reg', [AuthController::class, 'regPage'])->name('loginPost');
Route::post('/reg', [AuthController::class, 'Registration'])->name('loginPost');

Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.employee');

Route::get('/admin', function () {
    if (auth()->user() == null)
        return redirect()->route('login');

    return redirect()->route('login');
})->name('dashboard');
