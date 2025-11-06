<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return redirect('/wy/vocab/');
});

// 用户首页
Route::middleware(['auth:web'])->prefix('user')->name('user.')->group(function () {
  Route::get('dashboard', function () {
    return Inertia::render('User/Dashboard');
  })->name('dashboard');
});

// Admin 首页
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::get('dashboard', function () {
    return Inertia::render('Admin/Dashboard');
  })->name('dashboard');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
  Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
  Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
});