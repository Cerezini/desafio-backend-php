<?php

use Faker\Generator as Faker;

$factory->define('App\Models\Transaction', function (Faker $faker) {
    return [
        'payee_id' => $faker->unique()->randomNumber,
        'payer_id' => $faker->unique()->randomNumber,
        'transaction_date' => $faker->dateTime(),
        'value' => $faker->randomFloat(2, 0.01, 99.99)
    ];
});