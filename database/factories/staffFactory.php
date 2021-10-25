<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\staff;
use Faker\Generator as Faker;

$factory->define(staff::class, function (Faker $faker) {
    return [
        'id_pegawai' => $faker->unique()->numerify('################'),
        'nama' => $faker->name,
        'no_hp' => '08512345123',
        'alamat' => $faker->address,
        'jabatan_id' => $faker->numberBetween($min = 1, $max = 10)
        // 'url' => $faker->imageUrl($width = 300, $height = 300)
    ];
});
