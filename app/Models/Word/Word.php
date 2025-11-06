<?php

namespace App\Models\Word;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Word extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'library_id', 'word', 'phonetic', 'part_of_speech',
    'meaning', 'example', 'audio_url',
    'difficulty', 'language', 'tags',
    'is_active', 'created_by'
  ];

  protected $casts = [
    'tags' => 'array',
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (!$model->id) {
        $model->id = (string) Str::uuid();
      }
    });
  }

  public function library()
  {
    return $this->belongsTo(WordLibrary::class, 'library_id');
  }

  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }
}
