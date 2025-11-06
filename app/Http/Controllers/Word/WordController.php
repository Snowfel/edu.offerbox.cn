<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use App\Models\Word\Word;
use App\Models\Word\WordLibrary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WordController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('permission:view_word')->only(['index', 'show']);
    $this->middleware('permission:create_word')->only(['create', 'store']);
    $this->middleware('permission:edit_word')->only(['edit', 'update']);
    $this->middleware('permission:delete_word')->only(['destroy']);
  }

  public function index(Request $request)
  {
    $words = Word::with('library')
      ->when($request->input('keyword'), function ($query, $keyword) {
        $query->where('word', 'like', "%{$keyword}%");
      })
      ->when($request->input('library_id'), function ($query, $library_id) {
        $query->where('library_id', $library_id);
      })
      ->orderBy('id', 'desc')
      ->paginate(10)
      ->withQueryString();

    $libraries = WordLibrary::select('id', 'name')->get();

    return Inertia::render('Admin/Word/Index', [
      'words' => $words,
      'libraries' => $libraries,
      'filters' => $request->only('keyword', 'library_id'),
    ]);
  }

  public function create()
  {
    $libraries = WordLibrary::select('id', 'name')->get();
    return Inertia::render('Admin/Word/Create', [
      'libraries' => $libraries
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'library_id' => ['required', 'exists:word_libraries,id'],
      'word' => ['required', 'string', 'max:255'],
      'translation' => ['nullable', 'string'],
      'language' => ['nullable', 'string', 'max:20'],
      'tags' => ['nullable', 'string'],
      'difficulty' => ['nullable', 'integer', 'min:1', 'max:5'],
    ]);

    Word::create($data);

    return redirect()->route('admin.words.index')->with('success', '单词创建成功');
  }

  public function edit(Word $word)
  {
    $libraries = WordLibrary::select('id', 'name')->get();

    return Inertia::render('Admin/Word/Edit', [
      'word' => $word,
      'libraries' => $libraries
    ]);
  }

  public function update(Request $request, Word $word)
  {
    $data = $request->validate([
      'library_id' => ['required', 'exists:word_libraries,id'],
      'word' => ['required', 'string', 'max:255'],
      'translation' => ['nullable', 'string'],
      'language' => ['nullable', 'string', 'max:20'],
      'tags' => ['nullable', 'string'],
      'difficulty' => ['nullable', 'integer', 'min:1', 'max:5'],
    ]);

    $word->update($data);

    return redirect()->route('admin.words.index')->with('success', '单词更新成功');
  }

  public function destroy(Word $word)
  {
    $word->delete();
    return redirect()->back()->with('success', '单词已删除');
  }
}
