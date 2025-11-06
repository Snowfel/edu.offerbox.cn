<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that's loaded on the first page visit.
   */
  protected $rootView = 'app';

  /**
   * Define the props that are shared by default.
   */
  public function share(Request $request): array
  {
    // 获取 Admin 或 User
    $admin = Auth::guard('admin')->user();
    $user = Auth::guard('web')->user();

    // 获取当前登录用户及权限
    $authUser = null;
    if ($admin) {
      $authUser = [
        'id' => $admin->id,
        'name' => $admin->name,
        'email' => $admin->email,
        'roles' => $admin->roles->pluck('name')->toArray(),
        'permissions' => $admin->permissions() ?? [],
        'guard' => 'admin',
      ];
    } elseif ($user) {
      $authUser = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'roles' => $user->roles->pluck('name')->toArray() ?? [],
        'permissions' => $user->permissions() ?? [],
        'guard' => 'web',
      ];
    }

    return array_merge(parent::share($request), [
      'auth' => [
        'user' => $authUser,
      ],
      'flash' => [
        'success' => fn () => $request->session()->get('success'),
        'error' => fn () => $request->session()->get('error'),
      ],
    ]);
  }
}
