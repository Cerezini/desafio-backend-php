<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define('App\Models\User', function (Faker $faker) {
    return [
        'cpf' => $faker->unique()->cpf(false),
        'email' => $faker->unique()->safeEmail,
        'full_name' => $faker->name,
        'password' => $faker->sha256,
        'phone_number' => $faker->phoneNumberCleared
    ];
});