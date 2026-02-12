<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Logout route (for testing)
Route::post('/logout', function () {
    // Logout logic here
    return redirect('/');
})->name('logout');
