<?php

use Faker\Generator as Faker;

$factory->define(App\Offer::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory('App\Product')->create()->id;
        },
        'price' => $faker->randomNumber,
        'amount' => $faker->randomNumber,
        'sales' => $faker->randomNumber,
        'article' => $faker->word,
    ];
});
