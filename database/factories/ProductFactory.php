<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        "title" => $faker->sentence,
        "description" => $faker->text(),
        "image" => "https://via.placeholder.com/500",
        "price" => $faker->numberBetween(50, 750),
    ];
});
