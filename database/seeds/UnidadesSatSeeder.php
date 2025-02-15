<?php

use Illuminate\Database\Seeder;
use App\Models\UnidadSatModel;

class UnidadesSatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = [ ['clave' => 'H87', 'nombre' => 'Pieza'],
         ['clave' => 'EA', 'nombre' => 'Elemento'],
         ['clave' => 'E48', 'nombre' => 'Unidad de servicio'],
         ['clave' => 'ACT', 'nombre' => 'Actividad'],
         ['clave' => 'KGM', 'nombre' => 'Kilogramo'],
         ['clave' => 'E51', 'nombre' => 'Trabajo'],
         ['clave' => 'A9', 'nombre' => 'Tarifa'],
         ['clave' => 'MTR', 'nombre' => 'Metro'],
         ['clave' => 'AB', 'nombre' => 'Paquete a granel'],
         ['clave' => 'BB', 'nombre' => 'Caja base'],
         ['clave' => 'KT', 'nombre' => 'KIT'],
         ['clave' => 'SET', 'nombre' => 'Conjunto'],
         ['clave' => 'LTR', 'nombre' => 'Litro'],
         ['clave' => 'XBX', 'nombre' => 'Caja'],
         ['clave' => 'MON', 'nombre' => 'Mes'],
         ['clave' => 'HUR', 'nombre' => 'Hora'],
         ['clave' => 'MTK', 'nombre' => 'Metro Cuadrado'],
         ['clave' => '11', 'nombre' => 'Equipos'],
         ['clave' => 'MGM', 'nombre' => 'Miligramo'],
         ['clave' => 'XPK', 'nombre' => 'Paquete'],
         ['clave' => 'XKI', 'nombre' => 'Kit (Conjunto de piezas)'],
         ['clave' => 'AS', 'nombre' => 'Variedad'],
         ['clave' => 'GRM', 'nombre' => 'Gramo'],
         ['clave' => 'PR', 'nombre' => 'Par'],
         ['clave' => 'DPC', 'nombre' => 'Docenas de piezas'],
         ['clave' => 'XUN', 'nombre' => 'Unidad'],
         ['clave' => 'DAY', 'nombre' => 'Día'],
         ['clave' => 'XLT', 'nombre' => 'Lote'],
         ['clave' => '10', 'nombre' => 'Grupos'],
         ['clave' => 'MLT', 'nombre' => 'Mililitro'],
         ['clave' => 'E54', 'nombre' => 'Unidad específica de la industria (varias)'] 
        ]; 
        foreach ($unidades as $unidad) { UnidadSatModel::create($unidad); }
    }
}
