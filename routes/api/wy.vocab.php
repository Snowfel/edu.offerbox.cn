<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::prefix('wy/vocab')->controller(\App\Http\Controllers\Auth\WyLexiconController::class)->group(function () {
  Route::post('audio', 'getWordAudio')->name('api.wy.vocab.audio');
});
