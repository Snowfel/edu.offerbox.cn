<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('word_libraries', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('parent_id')->nullable()->index()->comment('父级词库ID');
      $table->string('name', 255)->comment('词库名称');
      $table->string('slug', 255)->nullable()->unique()->comment('别名/路径标识');
      $table->text('description')->nullable()->comment('描述');
      $table->integer('level')->default(1)->comment('层级深度');
      $table->string('path', 500)->nullable()->comment('层级路径, 例如 /1/5/12/');
      $table->integer('sort_order')->default(0)->comment('排序');
      $table->boolean('is_active')->default(true)->comment('是否启用');
      $table->uuid('created_by')->nullable()->comment('创建人ID');
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('parent_id')->references('id')->on('word_libraries')->nullOnDelete();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('word_libraries');
  }
};
