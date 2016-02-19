<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Budget\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Budget\Transaction::class, function (Faker\Generator $faker) {
	$desc = $faker->catchPhrase();
    return [
        'account' => $faker->optional($weight = 0.2)->randomDigit == null ? 'MasterCard' : 'Chequing',
        'date' => $faker->dateTimeThisMonth()->format('Y-m-d'),
        'description' => ucwords(strtolower($desc)),
        'amount' => $faker->numberBetween(100, 20000)/100,
        'category' => ucwords($faker->word()),
        'imported_description1' => strtoupper($desc),
    ];
});


