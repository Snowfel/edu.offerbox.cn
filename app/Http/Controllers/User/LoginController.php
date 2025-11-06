<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
  /**
   * 显示用户登录页
   */
  public function index()
  {
    return Inertia::render('User/Login', [
      'guard' => 'user',
      'flash' => [
        'error' => session('error'),
        'success' => session('success'),
      ],
    ]);
  }

  /**
   * 处理登录提交
   */
  public function submit(Request $request)
  {
    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember', false);

    $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'string'],
    ]);

    if (Auth::guard('web')->attempt($credentials, $remember)) {
      $request->session()->regenerate();

      return redirect()->intended(route('user.dashboard'));
    }

    return back()->withErrors([
      'email' => '邮箱或密码错误',
    ])->withInput($request->only('email', 'remember'));
  }

  /**
   * 注销
   */
  public function logout(Request $request)
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('user.login');
  }
}
