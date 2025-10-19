<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLexiconWordsTable extends Migration
{
  public function up()
  {
    Schema::create('lexicon_words', function (Blueprint $table) {
      $table->char('id', 26)->primary();
      $table->char('lexicon_id', 26);
      //$table->foreignId('lexicon_id')->constrained('lexicons')->cascadeOnDelete();
      $table->foreign('lexicon_id')->references('id')->on('lexicons')->onDelete('cascade');
      $table->string('word', 255);
      $table->text('definition')->nullable();
      $table->integer('order')->default(0);
      $table->softDeletes(); // deleted_at
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('lexicon_words');
  }
}
