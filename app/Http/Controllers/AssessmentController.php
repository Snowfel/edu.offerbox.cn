<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessmentController extends Controller
{
  public function storeAfast(Request $request)
  {
    $data = $request->validate([
      'answers' => 'required|array',
    ]);

    $answers = $data['answers'];
    $scores = [
      'achievement' => array_sum(array_slice($answers, 0, 8)) / 8,
      'learning' => array_sum(array_slice($answers, 8, 8)) / 8,
      'thinking' => array_sum(array_slice($answers, 16, 8)) / 8,
      'social' => array_sum(array_slice($answers, 24, 8)) / 8,
    ];

    $total = array_sum($scores) / 4;

    return response()->json([
      'scores' => $scores,
      'total' => round($total, 2),
      'level' => $this->getLevel($total),
    ]);
  }

  private function getLevel($avg)
  {
    if ($avg >= 4.5) return '极高潜力';
    if ($avg >= 4.0) return '高潜力';
    if ($avg >= 3.0) return '中等潜力';
    if ($avg >= 2.0) return '潜力有限';
    return '潜力较低';
  }
}
