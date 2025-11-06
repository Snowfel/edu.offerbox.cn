<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class AuthController extends Controller
{
  // 显示登录页
  public function showLogin(Request $request)
  {
    $guard = $this->getGuard($request);
    return Inertia::render('Login/Index', ['guard' => $guard]);
  }

  // 登录提交
  public function login(Request $request)
  {
    $guard = $this->getGuard($request);

    $request->validate([
      'email' => ['required','email'],
      'password' => ['required'],
    ]);

    if (Auth::guard($guard)->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
      $request->session()->regenerate();
      return redirect()->intended($guard === 'admin' ? route('admin.word-libraries.index') : route('user.dashboard'));
    }

    return back()->withErrors(['email' => '邮箱或密码错误'])->onlyInput('email');
  }

  // 登录状态检查
  public function check(Request $request)
  {
    $guard = $this->getGuard($request);
    return response()->json([
      'logged_in' => Auth::guard($guard)->check(),
      'user' => Auth::guard($guard)->user(),
    ]);
  }

  // 显示注册页
  public function showRegister(Request $request)
  {
    $guard = $this->getGuard($request);
    return Inertia::render('Login/Register', ['guard' => $guard]);
  }

  // 注册提交
  public function register(Request $request)
  {
    $guard = $this->getGuard($request);

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required','email','unique:' . ($guard === 'admin' ? 'admins' : 'users')],
      'password' => ['required','confirmed','min:6'],
    ]);

    $model = $guard === 'admin' ? Admin::class : User::class;
    $user = $model::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    Auth::guard($guard)->login($user);
    return redirect()->intended($guard === 'admin' ? route('admin.word-libraries.index') : route('user.dashboard'));
  }

  // 显示忘记密码页
  public function showForgotPassword(Request $request)
  {
    $guard = $this->getGuard($request);
    return Inertia::render('Login/ForgotPassword', ['guard' => $guard]);
  }

  // 发送重置密码邮件
  public function sendResetLink(Request $request)
  {
    $guard = $this->getGuard($request);
    $request->validate(['email' => ['required','email']]);

    $broker = $guard === 'admin' ? 'admins' : 'users';

    $status = Password::broker($broker)->sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
      ? back()->with('status', __($status))
      : back()->withErrors(['email' => __($status)]);
  }

  // 显示重置密码页
  public function showResetPassword(Request $request, $token)
  {
    $guard = $this->getGuard($request);
    return Inertia::render('Login/ResetPassword', [
      'guard' => $guard,
      'token' => $token,
      'email' => $request->email ?? '',
    ]);
  }

  // 提交重置密码
  public function resetPassword(Request $request)
  {
    $guard = $this->getGuard($request);

    $request->validate([
      'token' => ['required'],
      'email' => ['required','email'],
      'password' => ['required','confirmed','min:6'],
    ]);

    $broker = $guard === 'admin' ? 'admins' : 'users';

    $status = Password::broker($broker)->reset(
      $request->only('email','password','password_confirmation','token'),
      function ($user, $password) use ($guard) {
        $user->password = Hash::make($password);
        $user->save();
        Auth::guard($guard)->login($user);
      }
    );

    return $status === Password::PASSWORD_RESET
      ? redirect()->route($guard === 'admin' ? 'admin.word-libraries.index' : 'user.dashboard')->with('status', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }

  // 辅助函数：根据请求前缀返回 guard
  private function getGuard(Request $request)
  {
    return str_contains($request->route()->getPrefix(), 'admin') ? 'admin' : 'web';
  }
}
