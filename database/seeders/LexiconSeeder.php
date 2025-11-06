<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word\Word\Lexicon;
use App\Models\Word\Word\LexiconWord;

class LexiconSeeder extends Seeder
{
  public function run()
  {
    $l = Lexicon::create([
      'lexiconname' => '基础词汇 1000',
      'vocabcount' => 4,
      'orderid' => 1,
      'isreadlist' => true,
    ]);

    $l->words()->createMany([
      ['word'=>'apple','definition'=>'苹果','order'=>1],
      ['word'=>'banana','definition'=>'香蕉','order'=>2],
      ['word'=>'cat','definition'=>'猫','order'=>3],
      ['word'=>'dog','definition'=>'狗','order'=>4],
    ]);
  }
}
