<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\staff;
use Faker\Generator as Faker;

$factory->define(staff::class, function (Faker $faker) {
    return [
        'id_pegawai' => $faker->unique()->numerify('################'),
        'nama' => $faker->name,
        'no_hp' => '085xxxxxxxx',
        'alamat' => $faker->address,
        'url' => $faker->imageUrl($width = 300, $height = 300)
    ];
});
