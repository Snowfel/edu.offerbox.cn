<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LoginController extends Controller
{
  /**
   * 显示后台登录页
   */
  public function index()
  {
    return Inertia::render('Login', [
      'guard' => 'admin',
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
    Log::error($request->input());

    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember', false);

    // 验证基础字段
    $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'string'],
    ]);

    // 尝试使用 admin guard 登录
    if (Auth::guard('admin')->attempt($credentials, $remember)) {
      Log::error('login success!');
      $request->session()->regenerate();

      return redirect()->intended(route('admin.dashboard'));
    } else {
      Log::error('login failed!');
    }

    // 登录失败，返回错误 flash
    return back()->withErrors([
      'email' => '邮箱或密码错误',
    ])->withInput($request->only('email', 'remember'));
  }

  /**
   * 注销登录
   */
  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login.login');
  }
}
