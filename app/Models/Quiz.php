<?php

namespace App\Models;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';

    public function answer()
    {
        return $this->hasOne(Answer::class, 'id', 'answers_id');
    }
}
