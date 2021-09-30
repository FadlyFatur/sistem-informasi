<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\beranda;
use Faker\Generator as Faker;

$factory->define(beranda::class, function (Faker $faker) {
    return [
        'kontak' => $faker->tollFreePhoneNumber,
        'email'=> $faker->email,
        'alamat'=> $faker->address,
    ];
});
