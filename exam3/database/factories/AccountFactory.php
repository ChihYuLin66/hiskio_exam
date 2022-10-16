<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'amount' => $faker->numberBetween(1, 150) * 100,
        // 'balance' => 0,
    ];
});
