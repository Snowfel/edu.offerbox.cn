<?php

namespace App\Models\Word;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WordLibrary extends Model
{
  use HasUuid, SoftDeletes;

  protected $fillable = [
    'parent_id', 'name', 'slug', 'description',
    'level', 'path', 'sort_order', 'is_active', 'created_by'
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (!$model->id) {
        $model->id = (string) Str::uuid();
      }

      // 自动生成 slug
      if (empty($model->slug)) {
        $model->slug = Str::slug($model->name . '-' . Str::random(5));
      }
    });
  }

  public function parent()
  {
    return $this->belongsTo(self::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
  }

  public function words()
  {
    return $this->hasMany(Word::class, 'library_id');
  }

  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }
}
