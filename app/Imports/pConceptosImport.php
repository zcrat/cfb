<?php

namespace App\Imports;

use App\pConceptos2023;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class pConceptosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new pConceptos2023([
        'id' => $row['id'],
        'pCategorias_id' => $row['idcategoria'],
        'pTipos_id' => $row['idtipos'],
        'num' => $row['num'],
        'descripcion' => $row['descripcion'],
        'p_refaccion' => $row['preciorefaccion'],
        'tiempo' => $row['tiempo'],
        'p_mo' => $row['preciomanodeobra'],
        'pnuevo' => $row['precionuevo'],
        'p_total' => $row['preciototal'],
        'codigo_sat' => $row['codigosat'],
        'codigo_unidad' => $row['codigounidad'],
        'unidad_text' => $row['unidadtexto'],
        ]);
    }

    public function batchSize(): Int
    {
        return 1000;
    }

    public function chunkSize(): Int
    {
        return 1000;
    }

}
