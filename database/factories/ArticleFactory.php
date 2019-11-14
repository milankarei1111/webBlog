<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => '標題:'.$faker->catchPhrase(),
        'content' => $faker->realText($maxNbChars = 200, $indexSize = 1),
        'category_id' => $faker->numberBetween(1, 9),
        'image' => $faker->imageUrl(),
        'remark' => '[備註]'.$faker->bs(),
    ];
});
