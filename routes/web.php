<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Customers
Route::resource('customers', CustomerController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy']);
Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Logout route (for testing)
Route::post('/logout', function () {
    // Logout logic here
    return redirect('/');
})->name('logout');
