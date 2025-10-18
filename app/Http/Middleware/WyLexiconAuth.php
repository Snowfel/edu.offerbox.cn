<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WyLexiconAuth
{
  public function handle(Request $request, Closure $next)
  {
    $loginid = $request->session()->get('wy_lexicon_loginid');

    if ($loginid !== 'abc123') {
      // 未登录，返回 Inertia 页面而不是 redirect
      return inertia('Wy/Vocab/Unauthorized', [
        'message' => '登录已过期，请重新登录。',
      ]);
    }

    return $next($request);
  }
}
