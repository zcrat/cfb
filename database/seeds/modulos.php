<?php

use Illuminate\Database\Seeder;
use App\Models\Modulo;
use App\Models\AnioCorrespondiente;

class modulos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $MODULOS = ['PREDETERMINADO','CFE BAJIO','CFE OCCIDENTE','DESCONOCIDO','DESCONOCIDO','DESCONOCIDO','CFE ECO'];
        foreach($MODULOS as $modulo){
            Modulo::create([
                'descripcion' => $modulo
            ]);
        }
        $Anios=['2023','2024','2025','2026'];
        foreach($Anios as $Anio){
            AnioCorrespondiente::create([
                'descripcion' => $Anio
            ]);
    }
}
}
