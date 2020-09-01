<?php

namespace App\Http\Controllers\Quiz;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $quizs = Quiz::with(['answer'])
                ->inRandomOrder()
                ->limit(5)
                ->get();

        return QuizResource::collection($quizs);
    }
}
