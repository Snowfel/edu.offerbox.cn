<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
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
	return redirect('/home');
});


Route::get('/home', 'MainController@home')->name('home');

Route::get('/test', function () {
  return Inertia::render('Test', [
    'message' => 'Inertia + Vue3 已成功运行 🚀',
  ]);
});

Route::get('/login', function () {
  return Inertia::render('Auth/Login');
})->name('login');
