<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderBoardController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/verify/process', [AuthController::class, 'verifyProcess'])->name('verify.process');
Route::get('/verify-otp/{user}', [AuthController::class, 'otp'])->name('otp');

Route::post('/register/process', [AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/game/select-mode', [GameController::class, 'selectMode'])->name('game.select-mode')->middleware('auth');
Route::get('/game/{mode}', [GameController::class, 'game'])->name('game')->middleware('auth');

Route::post('/add-score', [GameController::class, 'addScore'])->name('game.add-score')->middleware('auth');

Route::get('/leaderboard', [LeaderBoardController::class, 'index'])->name('leaderboard')->middleware('auth');
