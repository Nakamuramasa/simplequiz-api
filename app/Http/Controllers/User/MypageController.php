<?php

namespace App\Http\Controllers\User;

use App\Models\Ranking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MypageController extends Controller
{
    public function index()
    {
        $myScore = Ranking::select('percentage_correct_answer', 'created_at')
            ->where('user_id', '=', auth()->id())
            ->orderby('created_at', 'asc')
            ->limit(100)
            ->get();

        $myScoreGraphData = [
            'percentage_correct_answer' => $myScore->pluck('percentage_correct_answer')->all(),
            'created_at' => $myScore->pluck('created_at')->all()
        ];

        return response()->json($myScoreGraphData, 200);
    }
}
