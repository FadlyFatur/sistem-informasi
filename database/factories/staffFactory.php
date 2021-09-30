<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\staff;
use Faker\Generator as Faker;

$factory->define(staff::class, function (Faker $faker) {
    return [
        'no_pegawai' => $faker->unique()->numerify('################'),
        'nama' => $faker->name,
        'no_hp' => $faker->phoneNumber,
        'alamat' => $faker->address,
        'url' =>$faker->imageUrl($width = 200, $height = 200)
    ];
});
