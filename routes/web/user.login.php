<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use Inertia\Inertia;

Route::prefix('user')->name('user.')->group(function () {
  Route::get('login', [LoginController::class, 'index'])->name('login');
  Route::post('login', [LoginController::class, 'submit'])->name('login.submit');
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');

  Route::middleware('auth:web')->group(function () {
    Route::get('dashboard', function () {
      return Inertia::render('User/Dashboard');
    })->name('dashboard');
  });
});

