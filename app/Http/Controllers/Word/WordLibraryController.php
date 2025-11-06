<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use App\Models\Word\WordLibrary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WordLibraryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('permission:view_word_library')->only(['index', 'show']);
    $this->middleware('permission:create_word_library')->only(['create', 'store']);
    $this->middleware('permission:edit_word_library')->only(['edit', 'update']);
    $this->middleware('permission:delete_word_library')->only(['destroy']);
  }

  /**
   * 显示词库列表
   */
  public function index(Request $request)
  {
    $libraries = WordLibrary::with('parent')
      ->withCount('children')
      ->when($request->input('keyword'), function ($query, $keyword) {
        $query->where('name', 'like', "%{$keyword}%");
      })
      ->orderBy('id', 'desc')
      ->paginate(10)
      ->withQueryString();

    return Inertia::render('Admin/WordLibrary/Index', [
      'libraries' => $libraries,
      'filters' => $request->only('keyword'),
    ]);
  }

  /**
   * 创建页面
   */
  public function create()
  {
    $parents = WordLibrary::select('id', 'name')->get();
    return Inertia::render('Admin/WordLibrary/Create', [
      'parents' => $parents
    ]);
  }

  /**
   * 保存新词库
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'parent_id' => ['nullable', 'exists:word_libraries,id'],
      'description' => ['nullable', 'string'],
    ]);

    WordLibrary::create($data);

    return redirect()->route('admin.word-libraries.index')->with('success', '词库创建成功');
  }

  /**
   * 编辑页面
   */
  public function edit(WordLibrary $wordLibrary)
  {
    $parents = WordLibrary::where('id', '<>', $wordLibrary->id)->select('id', 'name')->get();

    return Inertia::render('Admin/WordLibrary/Edit', [
      'library' => $wordLibrary,
      'parents' => $parents
    ]);
  }

  /**
   * 更新词库
   */
  public function update(Request $request, WordLibrary $wordLibrary)
  {
    $data = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'parent_id' => ['nullable', 'exists:word_libraries,id'],
      'description' => ['nullable', 'string'],
    ]);

    $wordLibrary->update($data);

    return redirect()->route('admin.word-libraries.index')->with('success', '词库更新成功');
  }

  /**
   * 删除词库
   */
  public function destroy(WordLibrary $wordLibrary)
  {
    $wordLibrary->delete();
    return redirect()->back()->with('success', '词库已删除');
  }
}
