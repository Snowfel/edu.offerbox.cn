<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::prefix('admin/login')->controller(LoginController::class)->group(function () {
  Route::get('/', 'index')->name('admin.login.login');
  Route::post('/submit', 'submit')->name('admin.login.submit');
  Route::post('/check', 'check')->name('admin.login.check');
});

Route::prefix('user/login')->controller(LoginController::class)->group(function () {
  Route::get('/', 'index')->name('user.login.index');
  Route::post('/submit', 'submit')->name('user.login.submit');
  Route::post('/check', 'check')->name('user.login.check');
});
