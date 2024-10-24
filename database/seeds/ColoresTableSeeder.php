<?php

use Illuminate\Database\Seeder;
use App\Color;

class ColoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colores = ['Blanco','Blanco Perla','Negro','Plata','Gris','Azul','Rojo','Amarillo','Dorado','Verde','Café Claro'];
        foreach($colores as $color){
            Color::create([
                'nombre' => $color
            ]);
        }
    }
}
