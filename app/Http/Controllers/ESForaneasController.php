<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ESForaneas;
use Illuminate\Support\Carbon;

class ESForaneasController extends Controller
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
                $entradassalidas = ESForaneas::where('fecha_salida','=',null)->orderBy('id', 'desc')->paginate(20);
                } else {
                $entradassalidas = ESForaneas::whereBetween('fecha_entrada', [$from, $to])->orderBy('id', 'desc')->paginate(20);
                }
        }
        else{
            $entradassalidas = ESForaneas::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);  
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

    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $entradasalida = new ESForaneas();
            $entradasalida->empresa = $request->empresa;
            $entradasalida->n_orden = $request->n_orden;
            $entradasalida->hora_entrada = $request->hora_entrada;
            $entradasalida->plaza = $request->orden_servicio;
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

            $entradasalida = ESForaneas::findOrFail($request->id);
            $entradasalida->empresa = $request->empresa;
            $entradasalida->n_orden = $request->n_orden;
            $entradasalida->hora_entrada = $request->hora_entrada;
            $entradasalida->plaza = $request->orden_servicio;
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

 
        $sucursal = ESForaneas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
}
