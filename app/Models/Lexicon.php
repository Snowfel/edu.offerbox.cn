<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lexicon extends Model
{
  use HasUlids, SoftDeletes;

  public $incrementing = false;
  protected $keyType = 'string';
  protected $fillable = [
    'lexiconname',
    'vocabcount',
    'isreadlist',
    'orderid',
  ];

  protected $casts = [
    'isreadlist' => 'boolean',
    'vocabcount' => 'integer',
    'orderid' => 'integer',
  ];

  public function words()
  {
    return $this->hasMany(LexiconWord::class, 'lexicon_id')->orderBy('order');
  }
}
