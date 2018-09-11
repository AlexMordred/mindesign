<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'image' => $faker->uuid . '.jpg',
        'description' => $faker->paragraph,
        'first_invoice' => $faker->dateTime,
        'url' => $faker->url,
        'price' => $faker->randomNumber,
        'amount' => $faker->randomNumber,
    ];
});
