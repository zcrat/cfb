<?php

use Illuminate\Database\Seeder;
use App\Persona;

class PersonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Tendra el id 1 por se el primero en registrarse
        $datos = 
        [
            [
            'id' => 1,
            'nombre' => 'Programador',
            'tipo_documento' => 'abc',
            'num_documento' => '1',
            'direccion' => 'Morelia, centro',
            'telefono' => '4431910000',
            'email' => 'admin@gmail.com',
        ],
        [
            'id' => 2,
            'nombre' => 'Oscar Akumas',
            'tipo_documento' => 'abc',
            'num_documento' => '1',
            'direccion' => 'Morelia, centro',
            'telefono' => '4431910000',
            'email' => 'oscar_akumas@akumas.mx',
        ],
        [
            'id' => 3,
            'nombre' => 'Mauricio Akumas',
            'tipo_documento' => 'abc',
            'num_documento' => '1',
            'direccion' => 'Morelia, centro',
            'telefono' => '4431910000',
            'email' => 'mauricio_akumas@akumas.mx',
        ],
        [
            'id' => 7,
            'nombre' => 'Iris Akumas',
            'tipo_documento' => 'abc',
            'num_documento' => '1',
            'direccion' => 'Morelia, centro',
            'telefono' => '4431910000',
            'email' => 'iris_akumas@akumas.mx',
        ],
        [
            'id' => 8,
            'nombre' => 'Froylan Akumas',
            'tipo_documento' => 'abc',
            'num_documento' => '1',
            'direccion' => 'Morelia, centro',
            'telefono' => '4431910000',
            'email' => 'froylan_akumas@akumas.mx',
        ],
        [
            'id' => 9,
            'nombre' => 'Araceli Akumas',
            'tipo_documento' => 'abc',
            'num_documento' => '1',
            'direccion' => 'Morelia, centro',
            'telefono' => '4431910000',
            'email' => 'araceli_akumas@akumas.mx',
        ],
        [
            'id' => 10,
            'nombre' => 'Analleli Akumas',
            'tipo_documento' => 'abc',
            'num_documento' => '1',
            'direccion' => 'Morelia, centro',
            'telefono' => '4431910000',
            'email' => 'analleli_akumas@akumas.mx',
        ]
        ];
    foreach($datos as $dato){
        Persona::create($dato);
    }
    }
}
