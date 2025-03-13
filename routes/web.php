<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/verify/process', [AuthController::class, 'verifyProcess'])->name('verify.process');
Route::get('/verify-otp/{user}', [AuthController::class, 'otp'])->name('otp');

Route::post('/register/process', [AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
