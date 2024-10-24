<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\TipoAuto;
use Faker\Generator as Faker;

$factory->define(TipoAuto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word
    ];
});
