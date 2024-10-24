<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Seguro;
use Faker\Generator as Faker;

$factory->define(Seguro::class, function (Faker $faker) {
    return [
        'cia_seg' => $faker->word,
        'tel_seg' => $faker->phoneNumber,
        'no_siniestro' => $faker->numberBetween(1,200),
        'ajustador' => $faker->numberBetween(1,100),
        'recepcion_vehicular_id' => $faker->numberBetween(1,10)
    ];
});
