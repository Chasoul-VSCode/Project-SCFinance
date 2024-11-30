<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;

Route::get('/', function () {
    return view('welcome');
});

//Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('app.dashboard');
Route::get('/home', function () {
    return redirect('/dashboard');
})->name('home');


Route::get('/kelola', function () {
    return view('pages.kelola');
})->name('kelola');
Route::post('/kelola', [FinanceController::class, 'store'])->name('finances.store');


Route::middleware(['auth'])->group(function () {
    Route::resource('finances', FinanceController::class);
});

Route::get('/report', function () {
    return view('pages.report');
})->name('report');