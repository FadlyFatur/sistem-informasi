<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\warga;
use Faker\Generator as Faker;

$factory->define(warga::class, function (Faker $faker) {
    return [
        'nik' => $faker->unique()->numerify('################'),
        'nama' => $faker->name,
        'jk' => 'L',
        'tempat_lahir' => $faker->city,
        'tanggal_lahir' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'alamat' => $faker->address,
        'kel' => 'sukapada',
        'kec' => 'cibeunying',
        'kota' => 'bandung',
        'rw' => '0' . $faker->numberBetween($min = 1, $max = 2),
        'rt' => '0' . $faker->numberBetween($min = 1, $max = 9),
        'agama' => 'Islam',
        'kerja_id' => $faker->numberBetween($min = 1, $max = 10),
        'kawin' => 'Belum menikah'
    ];
});
