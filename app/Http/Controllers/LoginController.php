<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LoginController extends Controller
{
  public function index()
  {
    return Inertia::render('Login/Index'); // 单独登录页面
  }
  public function submit(Request $request)
  {
    $pwd = $request->input('pwd');
    if ($pwd === 'hy2025') {
      $loginid = uniqid(); // 可以用 ULID 或随机字符串
      $request->session()->put('user_loginid', $loginid);
      return response()->json(['ret' => 'success', 'logined' => 1, 'loginid' => $loginid]);
    }

    return redirect()->back()->withErrors(['pwd' => '登录码错误']);
  }

  public function check(Request $request)
  {
    $loginid = $request->input('loginid');
    if ($loginid && $loginid === $request->session()->get('user_loginid')) {
      return response()->json(['ret' => 'success', 'logined' => 1]);
    }

    return response()->json(['ret' => 'fail', 'logined' => 0]);
  }

}
