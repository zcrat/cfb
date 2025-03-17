<?php

namespace App\Exports;

use App\PresupuestosCFE;
use Maatwebsite\Excel\Concerns\FromCollection;

class CotizacionesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PresupuestosCFE::all();
    }
}
