<?php

namespace App\Http\Controllers\zcrat;
use App\Http\Controllers\controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\HojaConcepto;
class Presupuestos extends Controller
{

    public function valesview(){
        
       
        return view('presupuestos.hojadeconceptos');
    }
}
