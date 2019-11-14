<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ArticleCategory;
use Faker\Generator as Faker;

$factory->define(ArticleCategory::class, function (Faker $faker) {
    return [
        //
        'name'=> '旅遊日誌',
        'description'=> '[描述]'.$faker->bs(),
    ];
});
