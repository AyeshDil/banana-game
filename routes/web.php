<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LeaderBoardController;
use App\Http\Controllers\MusicController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/verify/process', [AuthController::class, 'verifyProcess'])->name('verify.process');
Route::get('/verify-otp/{user}', [AuthController::class, 'otp'])->name('otp');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::post('/register/process', [AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/game/select-mode', [GameController::class, 'selectMode'])->name('game.select-mode')->middleware('auth');
Route::get('/game/{mode}', [GameController::class, 'game'])->name('game')->middleware('auth');

Route::post('/add-score', [GameController::class, 'addScore'])->name('game.add-score')->middleware('auth');

Route::get('/leaderboard', [LeaderBoardController::class, 'index'])->name('leaderboard')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::put('/profile-update/{user}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');


Route::post('/set-mute', [MusicController::class, 'muteAndUnmute'])->name('set-mute');