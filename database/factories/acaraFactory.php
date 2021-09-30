<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\acara;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\acara::class, function (Faker $faker) {
    $judul = $faker->sentence;
    return [
        'slug' => Str::slug($judul),
        'judul' => $judul,
        'deskripsi' => $faker->text($maxNbChars = 1000) ,
        'url' =>$faker->imageUrl($width = 200, $height = 200)
    ];
});
