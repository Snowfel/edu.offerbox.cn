<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
  /**
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string  $permission
   */
  public function handle(Request $request, Closure $next, string $permission)
  {
    $user = Auth::guard('admin')->user();
    if (!$user || !$user->hasPermission($permission)) {
      abort(403, '你没有权限访问此页面');
    }
    return $next($request);
  }
}
