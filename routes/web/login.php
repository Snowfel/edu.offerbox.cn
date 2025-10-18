<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::prefix('login')->controller(LoginController::class)->group(function () {
  Route::get('/', 'index')->name('user.login.index');
  Route::post('/submit', 'submit')->name('user.login.submit');
  Route::post('/check', 'check')->name('user.login.check');
});
