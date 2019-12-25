<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content'=> $faker->realText($maxNbChars = 100, $indexSize = 1),
        'user_id'=>$faker->numberBetween(1,10),
        'article_id'=>$faker->numberBetween(1,10),
    ];
});
