<?php

namespace App\Imports;

use App\Models\Word;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WordsImport implements ToCollection
{
  public function __construct(public string $library_id) {}

  public function collection(Collection $rows)
  {
    foreach ($rows->skip(1) as $row) { // 跳过标题行
      if (empty($row[0])) continue;

      Word::create([
        'library_id' => $this->library_id,
        'word' => $row[0],
        'phonetic' => $row[1] ?? null,
        'part_of_speech' => $row[2] ?? null,
        'meaning' => $row[3] ?? null,
        'example' => $row[4] ?? null,
        'difficulty' => (int)($row[5] ?? 1),
        'language' => $row[6] ?? 'en',
        'tags' => isset($row[7]) ? explode(',', $row[7]) : [],
        'is_active' => true,
      ]);
    }
  }
}
