<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
  // 登录
  Route::get('login', [AuthController::class, 'showLogin'])->name('login');
  Route::post('login', [AuthController::class, 'login'])->name('login.submit');
  Route::post('login/check', [AuthController::class, 'check'])->name('login.check');

  // 注册
  Route::get('register', [AuthController::class, 'showRegister'])->name('register');
  Route::post('register', [AuthController::class, 'register'])->name('register.submit');

  // 忘记密码
  Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
  Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
  Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
  Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});*/

/*Route::prefix('user')->name('user.')->group(function () {
  // 登录
  Route::get('login', [AuthController::class, 'showLogin'])->name('login.index');
  Route::post('login', [AuthController::class, 'login'])->name('login.submit');
  Route::post('login/check', [AuthController::class, 'check'])->name('login.check');

  // 注册
  Route::get('register', [AuthController::class, 'showRegister'])->name('register');
  Route::post('register', [AuthController::class, 'register'])->name('register.submit');

  // 忘记密码
  Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
  Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
  Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
  Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});*/

Route::post('/logout', function () {
  if (Auth::guard('admin')->check()) {
    Auth::guard('admin')->logout();
  } else {
    Auth::guard('web')->logout();
  }
  request()->session()->invalidate();
  request()->session()->regenerateToken();
  return redirect('/');
})->name('logout');