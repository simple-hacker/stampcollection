<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Issue;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    return [
        'cgbs_issue' => $faker->numberBetween(1,30000),
        'title' => $faker->word(3),
        'year' => 2019,
        'release_date' => $faker->dateTimeBetween('-1 year'),
        'description' => $faker->sentence(),
    ];
});
