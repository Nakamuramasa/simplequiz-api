<?php

namespace App\Http\Controllers\Quiz;

use DB;
use App\Models\Ranking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RankingController extends Controller
{
    protected $ranking;

    public function __construct(Ranking $ranking)
    {
        $this->ranking = $ranking;
    }

    public function index()
    {
        $totalRanking = Ranking::with('user')
            ->select(DB::raw('MAX(rankings.percentage_correct_answer) as percentage_correct_answer, rankings.user_id, rankings.created_at'))
            ->limit(5)
            ->orderby('percentage_correct_answer', 'desc')
            ->groupBy('rankings.user_id')
            ->get();

        $totalRankingData = [
            'percentage_correct_answer' => $totalRanking->pluck('percentage_correct_answer')->all(),
            'name' => $totalRanking->pluck('user.name')->all()
        ];

        return response()->json($totalRankingData, 200);
    }

    public function insertRanking(Request $request)
    {
        $correctRatio = $request->input('correctRatio');
        $this->ranking->insertScore((int) $correctRatio, auth()->id());

        return response()->json(['message' => 'Successful'], 200);
    }
}
