<?php

use Illuminate\Database\Seeder;
use App\TipoAuto;
class TipoAutoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = ['camioneta','coche','vagoneta'];
        foreach ($tipos as $tipo){
            TipoAuto::create([
                'nombre' => $tipo
            ]);
        }
    }
}
