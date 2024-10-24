<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Empresa;
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'rfc' => 'EUFA870518H53',
        'logo' => 'logo_cfe.png',
        'email' => 'designapp.mx@gmail.com',
        'direccion' => $faker->address,
        'telefono' => '4431910000'
    ];
});
