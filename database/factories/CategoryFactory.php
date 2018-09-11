<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    $title = $faker->words(3, true);
    
    return [
        'title' => $title,
        'alias' => str_slug($title),
        'parent' => null,
    ];
});
