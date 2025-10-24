<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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


  /**
   * 存储人才盘点绩效测评结果
   */
  public function storePerformance(Request $request)
  {
    // 验证输入
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|integer|exists:users,id',
      'answers' => 'required|array',
      'answers.*' => 'required|numeric|min:0|max:5',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors()
      ], 422);
    }

    $answers = $request->input('answers');

    // 计算总分（5分制）
    $total = count($answers) ? array_sum($answers) / count($answers) : 0;

    // 百分制
    $totalPercent = ($total / 5) * 100;

    // 计算等级
    $level = $this->getPerformanceLevel($total);

    // 存储到数据库
    /*$assessment = PerformanceAssessment::create([
      'user_id' => $request->input('user_id'),
      'answers' => json_encode($answers),
      'total_score' => $total,
      'total_percent' => $totalPercent,
      'level' => $level,
    ]);*/

    return response()->json([
      'status' => 'success',
      'data' => [
        //'assessment_id' => $assessment->id,
        'total' => $total,
        'total_percent' => $totalPercent,
        'level' => $level,
      ]
    ]);
  }

  /**
   * 根据总分获取绩效等级
   */
  private function getPerformanceLevel($score)
  {
    if ($score >= 4.5) return '卓越';       // 90-100
    if ($score >= 4.0) return '优秀';       // 80-89
    if ($score >= 3.0) return '满意';       // 70-79
    if ($score >= 2.0) return '待改进';     // 60-69
    return '不胜任';                        // 0-59
  }
}
