<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LexiconWord extends Model
{
  use HasUlids, SoftDeletes;

  protected $table = 'lexicon_words';
  public $incrementing = false;
  protected $keyType = 'string';

  protected $fillable = [
    'lexicon_id',
    'word',
    'definition',
    'order',
  ];

  public function lexicon()
  {
    return $this->belongsTo(Lexicon::class, 'lexicon_id');
  }
}
