<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use Inertia\Inertia;

/*Route::prefix('admin')->name('admin.')->group(function () {
  Route::get('login', [LoginController::class, 'index'])->name('login');
  Route::post('login', [LoginController::class, 'submit'])->name('login.submit');
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');

  Route::middleware('auth:admin')->group(function () {
    Route::get('dashboard', function () {
      return Inertia::render('Admin/Dashboard');
    })->name('dashboard');
  });
});*/
