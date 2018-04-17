<?php

use Faker\Generator as Faker;

$factory->define(App\File::class, function (Faker $faker) {
    return [
        'file' => $faker->word,
        'original_name' => $faker->word,
    ];
});
