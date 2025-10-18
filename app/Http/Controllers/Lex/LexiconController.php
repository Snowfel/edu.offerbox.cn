<?php

namespace App\Http\Controllers\Lex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VocabController extends Controller
{
  /**
   * 显示词库列表页
   */
  public function index()
  {
    $list = DB::table('tk_crm_wy_lexicon as A')
      ->where('A.vocabcount', '>', 1)
      ->where('A.isreadlist', 1)
      ->whereNull('A.deleted_at')
      ->orderBy('A.orderid')
      ->orderBy('A.lexiconname')
      ->get();

    return view('lex.index', ['list' => $list]);
  }

  /**
   * 登录码验证
   */
  public function login(Request $request)
  {
    $pwd = trim($request->input('pwd', ''));
    if ($pwd === config('services.lexicon.login_code')) {
      $loginid = Str::uuid()->toString();
      session(['wy_lexicon_loginid' => $loginid]);
      return response()->json(['ret' => 'success', 'loginid' => $loginid]);
    }
    return response()->json(['ret' => 'fail']);
  }

  /**
   * 检查本地登录ID是否有效
   */
  public function check(Request $request)
  {
    $loginid = $request->input('loginid');
    $logined = session('wy_lexicon_loginid') === $loginid ? 1 : 0;
    return response()->json(['ret' => 'success', 'logined' => $logined]);
  }
}
