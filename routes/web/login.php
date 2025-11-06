<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController as AdminLogin;
use App\Http\Controllers\User\LoginController as UserLogin;

Route::prefix('admin')->name('admin.')->group(function () {
  Route::get('login', [AdminLogin::class, 'index'])->name('login');
  Route::post('login', [AdminLogin::class, 'submit'])->name('login.submit');

  // 需要登录才能访问的后台页面
  Route::middleware('auth:admin')->group(function () {
    Route::get('dashboard', function () {
      return Inertia\Inertia::render('Admin/Dashboard');
    })->name('dashboard');

    Route::post('logout', [AdminLogin::class, 'logout'])->name('logout');
  });
});

Route::prefix('user')->name('user.')->group(function () {
  Route::get('login', [UserLogin::class, 'index'])->name('login');
  Route::post('login', [UserLogin::class, 'submit'])->name('login.submit');
});
