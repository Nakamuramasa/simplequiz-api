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
        $weekRanking = Ranking::with('user')
            ->select(DB::raw('MAX(rankings.percentage_correct_answer) as percentage_correct_answer, rankings.user_id, rankings.created_at'))
            ->whereBetween('rankings.created_at', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])
            ->limit(5)
            ->orderby('percentage_correct_answer', 'desc')
            ->groupBy('rankings.user_id')
            ->get();

        $weekRankingData = [
            'percentage_correct_answer' => $weekRanking->pluck('percentage_correct_answer')->all(),
            'username' => $weekRanking->pluck('user.username')->all()
        ];

        $monthRanking = Ranking::with('user')
            ->select(DB::raw('MAX(rankings.percentage_correct_answer) as percentage_correct_answer, rankings.user_id, rankings.created_at'))
            ->whereBetween('rankings.created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')])
            ->limit(5)
            ->orderby('percentage_correct_answer', 'desc')
            ->groupBy('rankings.user_id')
            ->get();

        $monthRankingData = [
            'percentage_correct_answer' => $monthRanking->pluck('percentage_correct_answer')->all(),
            'username' => $monthRanking->pluck('user.username')->all()
        ];

        $totalRanking = Ranking::with('user')
            ->select(DB::raw('MAX(rankings.percentage_correct_answer) as percentage_correct_answer, rankings.user_id, rankings.created_at'))
            ->limit(5)
            ->orderby('percentage_correct_answer', 'desc')
            ->groupBy('rankings.user_id')
            ->get();

        $totalRankingData = [
            'percentage_correct_answer' => $totalRanking->pluck('percentage_correct_answer')->all(),
            'username' => $totalRanking->pluck('user.username')->all()
        ];

        return response()->json([$weekRankingData, $monthRankingData, $totalRankingData], 200);
    }

    public function insertRanking(Request $request)
    {
        $correctRatio = $request->input('correctRatio');
        $this->ranking->insertScore((int) $correctRatio, auth()->id());

        return response()->json(['message' => 'Successful'], 200);
    }
}
