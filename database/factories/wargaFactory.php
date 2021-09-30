<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\warga;
use Faker\Generator as Faker;

$factory->define(warga::class, function (Faker $faker) {
    return [
        'nik' => $faker->unique()->numerify('################'),
        'nama_lengkap' => $faker->name,
        'jenis_kelamin' => 'L',
        'tempat_lahir' => $faker->city,
        'tanggal_lahir' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'alamat' => $faker->address,
        'kelurahan' => 'sukapada',
        'kecamatan' => 'cibeunying',
        'kota' => 'bandung',
        'rw' => '2',
        'rt' => $faker->numberBetween($min = 1, $max = 6),
        'agama_id' => 'islam',
        'kerja' => 'belum bekeja',
        'perkawinan' => 'belum menikah'
    ];
});
