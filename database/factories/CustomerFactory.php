<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'direccion' => $faker->address,
        'ciudad' => $faker->city,
        'estado' => $faker->word,
        'cp' => "80400",
        'tel_casa' => $faker->phoneNumber,
        'tel_oficina' => $faker->phoneNumber,
        'tel_celular' => $faker->phoneNumber,
        'email' => $faker->email,
        'empresa_id' => rand(1,5),
    ];
});
