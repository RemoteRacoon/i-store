<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

const places = 100;
const min = 1000;
const max = min * 10;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'label' => $faker->unique()->word,
        'rent_rate' => $faker->numberBetween(min * places, max * places) / places,
    ];
});
