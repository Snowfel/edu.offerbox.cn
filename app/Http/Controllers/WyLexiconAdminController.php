<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Lexicon;
use App\Models\LexiconWord;

class WyLexiconAdminController extends Controller
{
  // 列表（分页）
  public function index(Request $request)
  {
    $query = Lexicon::query()->where('isreadlist', true);

    if ($search = $request->input('q')) {
      $query->where('lexiconname', 'like', "%{$search}%");
    }

    $lexicons = $query->orderBy('orderid')->orderBy('lexiconname')
      ->paginate(12)
      ->through(fn($item) => [
        'id' => $item->id,
        'lexiconname' => $item->lexiconname,
        'vocabcount' => $item->vocabcount,
        'orderid' => $item->orderid,
      ]);

    return Inertia::render('Wy/LexiconAdmin/Index', [
      'lexicons' => $lexicons,
      'filters' => $request->only('q'),
      'flash' => [
        'success' => session('success'),
      ],
    ]);
  }

  // 新增表单
  public function create()
  {
    return Inertia::render('Wy/LexiconAdmin/Edit', [
      'lexicon' => [
        'id' => null,
        'lexiconname' => '',
        'vocabcount' => 0,
        'orderid' => 0,
      ],
      'mode' => 'create',
    ]);
  }

  // 存储
  public function store(Request $request)
  {
    $data = $request->validate([
      'lexiconname' => 'required|string|max:255',
      'vocabcount' => 'nullable|integer|min:0',
      'orderid' => 'nullable|integer',
      'isreadlist' => 'nullable|boolean',
    ]);

    $lexicon = Lexicon::create([
      'lexiconname' => $data['lexiconname'],
      'vocabcount' => $data['vocabcount'] ?? 0,
      'orderid' => $data['orderid'] ?? 0,
      'isreadlist' => $data['isreadlist'] ?? true,
    ]);

    return redirect()->route('wy.lexicon.admin.index')
      ->with('success', '新增词库成功');
  }

  // 编辑表单
  public function edit($id)
  {
    $lexicon = Lexicon::with('words')->findOrFail($id);

    return Inertia::render('Wy/LexiconAdmin/Edit', [
      'lexicon' => [
        'id' => $lexicon->id,
        'lexiconname' => $lexicon->lexiconname,
        'vocabcount' => $lexicon->vocabcount,
        'orderid' => $lexicon->orderid,
        'isreadlist' => $lexicon->isreadlist,
        'words' => $lexicon->words->map(fn($w) => [
          'id' => $w->id,
          'word' => $w->word,
          'definition' => $w->definition,
          'order' => $w->order,
        ]),
      ],
      'mode' => 'edit',
    ]);
  }

  // 更新
  public function update(Request $request, $id)
  {
    $lexicon = Lexicon::findOrFail($id);

    $data = $request->validate([
      'lexiconname' => 'required|string|max:255',
      'vocabcount' => 'nullable|integer|min:0',
      'orderid' => 'nullable|integer',
      'isreadlist' => 'nullable|boolean',
      // 可接收嵌套的 words 更新（简单示例）
      'words' => 'nullable|array',
      'words.*.id' => 'nullable|integer',
      'words.*.word' => 'required_with:words|string|max:255',
      'words.*.definition' => 'nullable|string',
      'words.*.order' => 'nullable|integer',
    ]);

    $lexicon->update([
      'lexiconname' => $data['lexiconname'],
      'vocabcount' => $data['vocabcount'] ?? $lexicon->vocabcount,
      'orderid' => $data['orderid'] ?? $lexicon->orderid,
      'isreadlist' => $data['isreadlist'] ?? $lexicon->isreadlist,
    ]);

    // 处理 words（简单策略：如果有 id 则更新，否则创建）
    if (!empty($data['words']) && is_array($data['words'])) {
      foreach ($data['words'] as $w) {
        if (!empty($w['id'])) {
          $word = LexiconWord::find($w['id']);
          if ($word) {
            $word->update([
              'word' => $w['word'],
              'definition' => $w['definition'] ?? null,
              'order' => $w['order'] ?? 0,
            ]);
          }
        } else {
          $lexicon->words()->create([
            'word' => $w['word'],
            'definition' => $w['definition'] ?? null,
            'order' => $w['order'] ?? 0,
          ]);
        }
      }

      // 同步词数（简易）
      $lexicon->update(['vocabcount' => $lexicon->words()->count()]);
    }

    return redirect()->route('wy.lexicon.admin.index')
      ->with('success', '词库更新成功');
  }

  // 删除
  public function destroy($id)
  {
    $lexicon = Lexicon::findOrFail($id);
    $lexicon->delete();
    return redirect()->back()->with('success', '词库已删除');
  }
}
