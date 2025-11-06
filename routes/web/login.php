<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController as AdminLogin;
use App\Http\Controllers\User\LoginController as UserLogin;

Route::prefix('admin')->name('admin.')->group(function () {
  Route::get('login', [AdminLogin::class, 'index'])->name('login');
  Route::post('login', [AdminLogin::class, 'submit'])->name('login.submit');
});

Route::prefix('user')->name('user.')->group(function () {
  Route::get('login', [UserLogin::class, 'index'])->name('login');
  Route::post('login', [UserLogin::class, 'submit'])->name('login.submit');
});
