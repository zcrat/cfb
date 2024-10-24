<?php

use Illuminate\Database\Seeder;
use App\EstadoEquipo;

class EstadoEquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            'Seleccione',
            'Sin daño visible',
            'Operacional',
            'Falta Objeto',
            'Dañada',
            'Reparación Necesaria',
            'No Aplica',
        ];
        foreach ($estados as $estado){
            EstadoEquipo::create(
                ['nombre' => $estado]
            );
        }
    }
}
