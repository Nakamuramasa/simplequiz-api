<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models;
use App\Models\User;
use App\Models\Ranking;
use Faker\Generator as Faker;

$factory->define(Ranking::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'percentage_correct_answer' => rand(0, 10) * 10,
    ];
});
