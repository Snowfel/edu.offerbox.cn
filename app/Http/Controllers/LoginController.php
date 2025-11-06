<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
  /**
   * 显示登录页面
   */
  public function index(Request $request)
  {
    return Inertia::render('Login/Index', [
      'guard' => $request->route()->getPrefix() === 'admin/login' ? 'admin' : 'web',
    ]);
  }

  /**
   * 提交登录
   */
  public function submit(Request $request)
  {
    $request->validate([
      'email' => ['required','email'],
      'password' => ['required'],
      'remember' => ['nullable','boolean'],
    ]);

    $guard = $request->route()->getPrefix() === 'admin/login' ? 'admin' : 'web';

    if (Auth::guard($guard)->attempt([
      'email' => $request->email,
      'password' => $request->password,
    ], $request->remember)) {
      $request->session()->regenerate();

      return redirect()->intended($guard === 'admin' ? route('admin.word-libraries.index') : route('user.dashboard'));
    }

    return back()->withErrors([
      'email' => '邮箱或密码错误',
    ])->onlyInput('email');
  }

  /**
   * 登录状态检查（可用于 Ajax/前端验证）
   */
  public function check(Request $request)
  {
    $guard = $request->route()->getPrefix() === 'admin/login' ? 'admin' : 'web';

    return response()->json([
      'logged_in' => Auth::guard($guard)->check(),
      'user' => Auth::guard($guard)->user(),
    ]);
  }
}
