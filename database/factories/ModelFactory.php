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
        'date' => $faker->dateTimeBetween(Carbon\Carbon::now()->startOfMonth(), Carbon\Carbon::now()->endOfMonth())->format('Y-m-d'),
        'description' => ucwords(strtolower($desc)),
        'amount' => $faker->numberBetween(100, 20000)/100,
        'category' => ucwords($faker->word()),
        'imported_description1' => strtoupper($desc),
    ];
});

$factory->define(Budget\Budget::class, function (Faker\Generator $faker) {
    $types = ['Ignored', 'Income', 'Expense'];
    return [
        'category'  => ucwords($faker->word()),
        'amount'    => $faker->numberBetween(100, 20000)/100,
        'month'     => Carbon\Carbon::now()->startOfMonth()->toDateTimeString(), 
        'variable'  => $faker->optional($weight = 0.3)->randomDigit == null ? 1 : 0,
        'type'      => $types[$faker->biasedNumberBetween(0, 2)],
    ];
});

$factory->defineAs(Budget\Budget::class, 'Ignored', function (Faker\Generator $faker) use ($factory) {
    $budget = $factory->raw(Budget\Budget::class);
    return array_merge($budget, ['type' => 'Ignored']);
});

$factory->defineAs(Budget\Budget::class, 'Income', function (Faker\Generator $faker) use ($factory) {
    $budget = $factory->raw(Budget\Budget::class);
    return array_merge($budget, ['type' => 'Income']);
});

$factory->defineAs(Budget\Budget::class, 'Expense', function (Faker\Generator $faker) use ($factory) {
    $budget = $factory->raw(Budget\Budget::class);
    return array_merge($budget, ['type' => 'Expense']);
});
