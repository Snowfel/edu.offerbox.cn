<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('words', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('library_id')->index()->comment('所属词库ID');
      $table->string('word', 255)->index()->comment('单词本身');
      $table->string('phonetic', 255)->nullable()->comment('音标');
      $table->string('part_of_speech', 50)->nullable()->comment('词性');
      $table->text('meaning')->comment('释义');
      $table->text('example')->nullable()->comment('例句');
      $table->string('audio_url', 500)->nullable()->comment('音频文件路径');
      $table->tinyInteger('difficulty')->default(1)->comment('难度等级 1-5');
      $table->string('language', 10)->default('en')->comment('语言代码');
      $table->json('tags')->nullable()->comment('标签');
      $table->boolean('is_active')->default(true)->comment('是否启用');
      $table->uuid('created_by')->nullable()->comment('创建人ID');
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('library_id')->references('id')->on('word_libraries')->cascadeOnDelete();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('words');
  }
};
