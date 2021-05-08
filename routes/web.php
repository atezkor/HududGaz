<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/admin', function () {
    if (auth()->user() == null)
        return redirect()->route('login');
    return redirect()->route('login');
});
