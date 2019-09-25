<?php

use Faker\Generator as Faker;

$factory->define('App\Models\Seller', function (Faker $faker) {
    return [
        'cnpj' => $faker->unique()->cnpj(false),
        'fantasy_name' => $faker->company,
        'social_name' => $faker->company,
        'user_id' => $faker->unique()->randomNumber,
        'username' => $faker->unique()->userName
    ];
});