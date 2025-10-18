<?php

namespace App\Http\Controllers;

use App\Models\Lexicon;
use App\Models\LexiconWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class WyLexiconController extends Controller
{
  public function index(Request $request)
  {
    $query = Lexicon::query()->where('isreadlist', true);

    if ($search = $request->input('q')) {
      $query->where('lexiconname', 'like', "%{$search}%");
    }

    $list = $query->orderBy('orderid')->orderBy('lexiconname')->get();

    Log::error(json_encode($list, JSON_UNESCAPED_UNICODE));

    return Inertia::render('Wy/Vocab/Index', [
      'list' => $list->toArray() ?: [],
    ]);
  }


  public function show(Request $request, $id)
  {
    $words = [
      1 => ['apple', 'banana', 'cat', 'dog'],
      2 => ['IELTS', 'band', 'essay', 'fluency'],
      3 => ['TOEFL', 'reading', 'speaking', 'writing'],
    ];

    $list = LexiconWord::where('lexicon_id', $id)->get();

    Log::error(json_encode($list, JSON_UNESCAPED_UNICODE));

    return Inertia::render('Wy/Vocab/Show', [
      'id' => $id,
      'lexiconname' => "词库 #$id",
      'words' => $list ?? [],
    ]);
  }
}
