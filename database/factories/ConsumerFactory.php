<?php

use Faker\Generator as Faker;

$factory->define('App\Models\Consumer', function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->randomNumber,
        'username' => $faker->unique()->userName
    ];
});