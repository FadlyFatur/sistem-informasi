<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\beranda;
use Faker\Generator as Faker;

$factory->define(beranda::class, function (Faker $faker) {
    return [
        'kontak' => $faker->tollFreePhoneNumber,
        'email' => $faker->email,
        'alamat' => $faker->address,
        'visi' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'misi' => $faker->sentence($nbWords = 12, $variableNbWords = true),
    ];
});
