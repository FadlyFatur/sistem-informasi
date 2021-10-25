<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\warga;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Crypt;

$factory->define(warga::class, function (Faker $faker) {
    return [
        'nik' => $faker->unique()->numerify('################'),
        'nama' => $faker->name,
        'jk' => 'L',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'alamat' => 'Jl. Pelita 2 No.' . $faker->numberBetween($min = 1, $max = 50),
        'kel' => 'Sukapada',
        'kec' => 'Cibeunying',
        'kota' => 'Bandung',
        'rw' => '0' . $faker->numberBetween($min = 1, $max = 2),
        'rt' => '0' . $faker->numberBetween($min = 1, $max = 5),
        'agama' => 'Islam',
        'kerja_id' => $faker->numberBetween($min = 1, $max = 10),
        'kawin' => 'Belum menikah'
    ];
});
