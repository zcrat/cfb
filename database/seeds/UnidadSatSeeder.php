<?php

use Illuminate\Database\Seeder;
use App\UnidadSat;

class UnidadSatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            ['id' => 1,'code' => 'H87','nombre' => 'Pieza','descripcion' => 'Unidad de conteo que define el número de piezas (pieza: un solo artículo, artículo o ejemplar).'],
            ['id' => 2,'code' => 'C62','nombre' => 'Uno','descripcion' => 'Sinónimo: unidad'],
            ['id' => 3,'code' => 'EA','nombre' => 'Elemento','descripcion' => 'Unidad de conteo que define el número de elementos considerados como unidades separadas.'],
            ['id' => 4,'code' => 'E48','nombre' => 'Unidad de Servicio','descripcion' => 'Unidad de conteo que define el número de unidades de servicio (unidad de servicio: definido período / propiedad / centro / utilidad de alimentación).'],
            ['id' => 5,'code' => 'ACT','nombre' => 'Actividad','descripcion' => 'Unidad de recuento para definir el número de actividades (actividad: una unidad de trabajo o acción).'],
            ['id' => 6,'code' => 'KGM','nombre' => 'Kilogramo','descripcion' => 'Una unidad de masa igual a mil gramos.'],
            ['id' => 7,'code' => 'E51','nombre' => 'Trabajo','descripcion' => 'Unidad de recuento de definir el número de puestos de trabajo.'],
            ['id' => 8,'code' => 'A9','nombre' => 'Tarifa','descripcion' => 'Unidad de cantidad expresada como una tasa para el uso de una instalación o servicio.'],
            ['id' => 9,'code' => 'MTR','nombre' => 'Metro','descripcion' => 'El metro (símbolo m) es la principal unidad de longitud del Sistema Internacional de Unidades.'],
            ['id' => 10,'code' => 'AB','nombre' => 'Paquete a granel','descripcion' => 'Unidad de recuento para definir el número de artículos por paquete a granel.	Seleccionar\r\n'],
            ['id' => 11,'code' => 'BB','nombre' => 'caja base','descripcion' => 'Una unidad de área de 112 hojas de productos de estaño (placa de estaño, acero libre de estaño o placa negra) 14 por 20 pulgadas o 31,360 pulgadas cuadradas.'],
            ['id' => 12,'code' => 'KT','nombre' => 'Kit','descripcion' => 'Unidad de conteo que define el número de kits (kit: bañera, barril o cubo).	Seleccionar\r\n'],
            ['id' => 13,'code' => 'SET','nombre' => 'Conjunto','descripcion' => 'Unidad de conteo que define el número de conjuntos (Conjunto: un número de objetos agrupados)'],
            ['id' => 14,'code' => 'LTR','nombre' => 'Litro','descripcion' => 'Es una unidad de volumen equivalente a un decímetro cúbico (1 dm³). Su uso es aceptado en el Sistema Internacional de Unidades (SI), aunque ya no pertenece estrictamente a él.'],
            ['id' => 15,'code' => 'MTK','nombre' => 'Metro cuadrado','descripcion' => 'Es la unidad básica de superficie en el Sistema Internacional de Unidades. Si a esta unidad se antepone un prefijo del Sistema Internacional se crea un múltiplo o submúltiplo de esta.'],
            ['id' => 16,'code' => 'KMK','nombre' => 'Kilómetro cuadrado','descripcion' => 'Es la unidad de superficie de área que se corresponde con un cuadrado de un kilómetro de lado.']

        ];
        foreach($datos as $dato){
            UnidadSat::create($dato);
        }
    }
}
