<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\EntradasSalidas;
use Illuminate\Support\Carbon;

class EntradasSalidasController extends Controller
{
    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $from = Carbon::parse($request->from)->format('Y-m-d');
        $to = Carbon::parse($request->to)->format('Y-m-d');
        
        
        if ($buscar==''){
           
            if($request->from == ''){
                $entradassalidas = EntradasSalidas::where('fecha_salida','=',null)->orderBy('id', 'desc')->paginate(20);
                } else {
                $entradassalidas = EntradasSalidas::whereBetween('fecha_entrada', [$from, $to])->orderBy('id', 'desc')->paginate(20);
                }
        }
        else{
            $entradassalidas = EntradasSalidas::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);  
        }
        
        return [
            'pagination' => [
                'total'        => $entradassalidas->total(),
                'current_page' => $entradassalidas->currentPage(),
                'per_page'     => $entradassalidas->perPage(),
                'last_page'    => $entradassalidas->lastPage(),
                'from'         => $entradassalidas->firstItem(),
                'to'           => $entradassalidas->lastItem(),
            ],
            'entradassalidas' => $entradassalidas 
        ];
    }
    public function index2(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $from = Carbon::parse($request->from)->format('Y-m-d');
        $to = Carbon::parse($request->to)->format('Y-m-d');
        
        
        $entradassalidas = EntradasSalidas::whereBetween($criterio, [$from, $to])->orderBy('id', 'desc')->paginate(500);
        
        return [
            'pagination' => [
                'total'        => $entradassalidas->total(),
                'current_page' => $entradassalidas->currentPage(),
                'per_page'     => $entradassalidas->perPage(),
                'last_page'    => $entradassalidas->lastPage(),
                'from'         => $entradassalidas->firstItem(),
                'to'           => $entradassalidas->lastItem(),
            ],
            'entradassalidas' => $entradassalidas 
        ];
    }

    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $entradasalida = new EntradasSalidas();
            $entradasalida->empresa = $request->empresa;
            $entradasalida->n_orden = $request->n_orden;
            $entradasalida->hora_entrada = $request->hora_entrada;
            $entradasalida->orden_servicio = $request->orden_servicio;
            $entradasalida->economico = $request->economico;
            $entradasalida->placas =  $request->placas;    
            $entradasalida->kms = $request->kms; 
            $entradasalida->serie = $request->serie; 
            $entradasalida->fecha_entrada = $request->fecha_entrada; 
            $entradasalida->fecha_salida = $request->fecha_salida; 
            $entradasalida->observaciones = $request->observaciones;    
            $entradasalida->asignado = $request->asignado; 
            $entradasalida->save();
         


            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $entradasalida = EntradasSalidas::findOrFail($request->id);
            $entradasalida->empresa = $request->empresa;
            $entradasalida->n_orden = $request->n_orden;
            $entradasalida->hora_entrada = $request->hora_entrada;
            $entradasalida->orden_servicio = $request->orden_servicio;
            $entradasalida->economico = $request->economico;
            $entradasalida->placas =  $request->placas;    
            $entradasalida->kms = $request->kms; 
            $entradasalida->serie = $request->serie; 
            $entradasalida->fecha_entrada = $request->fecha_entrada; 
            $entradasalida->fecha_salida = $request->fecha_salida; 
            $entradasalida->observaciones = $request->observaciones;    
            $entradasalida->asignado = $request->asignado;    
            $entradasalida->save();

        
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function delete(Request $request){

 
        $sucursal = EntradasSalidas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
}
