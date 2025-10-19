<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLexiconsTable extends Migration
{
  public function up()
  {
    Schema::create('lexicons', function (Blueprint $table) {
      $table->char('id', 26)->primary();
      $table->string('lexiconname', 255);
      $table->unsignedInteger('vocabcount')->default(0);
      $table->boolean('isreadlist')->default(true);
      $table->integer('orderid')->default(0);
      $table->softDeletes(); // deleted_at
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('lexicons');
  }
}
