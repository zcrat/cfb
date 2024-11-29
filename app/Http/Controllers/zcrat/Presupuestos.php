<?php

namespace App\Http\Controllers\zcrat;
use App\Http\Controllers\controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\HojaConcepto;
use App\Models\RecepcionVehicular;
class Presupuestos extends Controller
{

    public function valesview(){
        
       
        return view('presupuestos.hojadeconceptos');
    }
    public function vale(Request $request){
        
       $vale=RecepcionVehicular::where("id",$request->input("id"))->first();

        return response()->json($vale);
    }
}
