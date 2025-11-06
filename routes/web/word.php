<?php
use App\Http\Controllers\Auth\Word\WordLibraryController;
use App\Http\Controllers\Auth\Word\WordController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:super-admin|editor'])->prefix('admin')->name('admin.')->group(function () {

  // 词库管理
  Route::prefix('word-libraries')->name('wordlibraries.')->group(function () {
    Route::get('/', [WordLibraryController::class, 'index'])->name('index');
    Route::post('/', [WordLibraryController::class, 'store'])->name('store');
    Route::get('/{id}', [WordLibraryController::class, 'show'])->name('show');
    Route::put('/{id}', [WordLibraryController::class, 'update'])->name('update');
    Route::delete('/{id}', [WordLibraryController::class, 'destroy'])->name('destroy');
  });

  // 单词管理
  Route::prefix('words')->name('words.')->group(function () {
    Route::get('/', [WordController::class, 'index'])->name('index');
    Route::post('/', [WordController::class, 'store'])->name('store');
    Route::get('/{id}', [WordController::class, 'show'])->name('show');
    Route::put('/{id}', [WordController::class, 'update'])->name('update');
    Route::delete('/{id}', [WordController::class, 'destroy'])->name('destroy');
    Route::post('/import', [WordController::class, 'import'])->name('import');
  });
});
