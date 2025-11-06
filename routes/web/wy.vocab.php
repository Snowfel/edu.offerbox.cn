<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VocabularyController;
use App\Http\Controllers\Auth\WyLexiconController;

Route::prefix('wy/vocab')->group(function () {
  Route::get('/', [WyLexiconController::class, 'index'])->name('wy.lexicon.index');

  // 词库详情页（需要登录）
  Route::get('/list/{id}', [WyLexiconController::class, 'show'])
    ->middleware('wy.lexicon.auth')
    ->name('wy.lexicon.show');
});

Route::prefix('wy/admin/lexicon')->middleware(['web','auth'])->group(function () {
  Route::get('/', [VocabularyController::class, 'index'])->name('wy.lexicon.admin.index');
  Route::get('/create', [VocabularyController::class, 'create'])->name('wy.lexicon.admin.create');
  Route::post('/', [VocabularyController::class, 'store'])->name('wy.lexicon.admin.store');
  Route::get('/{id}/edit', [VocabularyController::class, 'edit'])->name('wy.lexicon.admin.edit');
  Route::put('/{id}', [VocabularyController::class, 'update'])->name('wy.lexicon.admin.update');
  Route::delete('/{id}', [VocabularyController::class, 'destroy'])->name('wy.lexicon.admin.destroy');
});
