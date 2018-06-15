<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'type' => $faker->randomElement(['shirt', 't-shirt', 'hoodie', 'socks', 'pants']),
        'color' => strtolower($faker->colorName),
        'size' => $faker->randomElement(['S', 'M', 'L', 'XL']),
        'price' => $faker->randomNumber(4),
    ];
});
