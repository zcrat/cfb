<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\anexosForaneosRecepcionAcuse;
use App\anexosFVehiculos;
use App\anexosFGenerales;
use App\anexosForaneos;
use App\pCFEVehiculos;
use App\pCFEGenerales;
use App\presupuestosCFE;
use DB;
use Illuminate\Support\Carbon;
use App\ESForaneas;
use App\Empresa;
use App\OrdenesForaneas;

class anexosForaneosRecepcionAcuseController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $contra = $request->contra;
        $criterio = $request->criterio;
        $contratos = Empresa::get();

        if(\Auth::user()->id == 1){

            if ($buscar==''){
                $cotizaciones = anexosForaneosRecepcionAcuse::where('eco_id','=',$request->eco_id)->orderBy('id', 'desc')
                ->paginate(20);
            }
            else{
                $cotizaciones = anexosForaneosRecepcionAcuse::where('eco_id','=',$request->eco_id)->where($criterio, 'like', '%'. $buscar . '%')
                ->orderBy('id', 'desc')
                ->paginate(20);
            }

        } else {

            if ($buscar==''){
                $cotizaciones = anexosForaneosRecepcionAcuse::where('eco_id','=',$request->eco_id)->where('user_id','=',\Auth::user()->id)
                ->orderBy('id', 'desc')
                ->paginate(20);
            }
            else{
                $cotizaciones = anexosForaneosRecepcionAcuse::where('eco_id','=',$request->eco_id)->where($criterio, 'like', '%'. $buscar . '%')
                ->where('user_id','=',\Auth::user()->id)
                ->orderBy('id', 'desc')
                ->paginate(20);
            }



        }
     
       
       
         
        return [
            'pagination' => [
                'total'        => $cotizaciones->total(),
                'current_page' => $cotizaciones->currentPage(),
                'per_page'     => $cotizaciones->perPage(),
                'last_page'    => $cotizaciones->lastPage(),
                'from'         => $cotizaciones->firstItem(),
                'to'           => $cotizaciones->lastItem(),
            ],
            'cotizaciones' => $cotizaciones,
            'clientes' => $contratos,
        ];
    }

    public function store(Request $request)
    {
       
  
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            $fechita = Carbon::parse($request->fecha)->format('Y-m-d');

            $num = DB::table('anexosFRAcuse')->count();

            $os='';

            if($request->casanova == 0){
 
                 
            if($num == 0){
                $clave = 'FORA'.'00001'; 
            } else {
                $numeros = $num + 1;
                $numeroConCeros = str_pad($numeros, 5, "0", STR_PAD_LEFT);
                $clave = 'FORA'.$numeroConCeros;

            }
            $os = $request->orden_servicio;

            } else if($request->casanova == 1) {
                
                $clave = $request->orden_servicio;
                $os = $request->orden_id;
            }

            $anexoFRA = new anexosForaneosRecepcionAcuse();
            $anexoFRA->folioNum = $clave;
            $anexoFRA->user_id = \Auth::user()->id;
            $anexoFRA->empresa_id =  $request->empresa_id;
            $anexoFRA->fecha = $fechita;
            $anexoFRA->no_economico = $request->no_economico;
            $anexoFRA->placas = $request->placas;
            $anexoFRA->marca =$request->marca;
            $anexoFRA->submarca =$request->submarca;
            $anexoFRA->modelo = $request->modelo;
            $anexoFRA->no_serie =$request->no_serie;
            $anexoFRA->tipo_de_vehiculo =$request->tipo_de_vehiculo;
            $anexoFRA->tipo_de_servicio =$request->tipo_de_servicio;
            $anexoFRA->observaciones =$request->observaciones;
            $anexoFRA->nombre_taller =$request->nombre_taller;
            $anexoFRA->razon_social =$request->razon_social;
            $anexoFRA->usuario =$request->usuario;
            $anexoFRA->rpe =$request->rpe;
            $anexoFRA->km_entrada =$request->km_entrada;
            $anexoFRA->orden_servicio =$request->orden_servicio;
            $anexoFRA->orden_id =$request->orden_id;
            $anexoFRA->ClienteYRazonSocial = $request->a;
            $anexoFRA->Mail = $request->b;
            $anexoFRA->Telefono = $request->c;
            $anexoFRA->Conductor = $request->d;
            $anexoFRA->eco_id = $request->eco_id;
            $anexoFRA->save(); 

            $empresa = anexosForaneosRecepcionAcuse::join('empresas','anexosFRAcuse.empresa_id','=','empresas.id')
            ->select('anexosFRAcuse.id','empresas.nombre','anexosFRAcuse.empresa_id','anexosFRAcuse.fecha','anexosFRAcuse.no_economico','anexosFRAcuse.placas','anexosFRAcuse.marca','anexosFRAcuse.submarca','anexosFRAcuse.modelo','anexosFRAcuse.no_serie','anexosFRAcuse.tipo_de_vehiculo','anexosFRAcuse.tipo_de_servicio','anexosFRAcuse.observaciones','anexosFRAcuse.nombre_taller','anexosFRAcuse.razon_social','anexosFRAcuse.usuario','anexosFRAcuse.rpe','anexosFRAcuse.km_entrada','anexosFRAcuse.orden_servicio','anexosFRAcuse.orden_id','anexosFRAcuse.folioNum')
            ->where('anexosFRAcuse.id','=',$anexoFRA->id)->orderBy('anexosFRAcuse.id', 'desc')->take(1)->get();

            if($request->con_id == 0){
                $vehiculo = new anexosFVehiculos();
                $vehiculo->identificador = $request->no_economico;
                $vehiculo->modelo = $request->submarca;
                $vehiculo->vin = $request->no_serie;
                $vehiculo->placas = $request->placas;
                $vehiculo->ano = $request->modelo;
                $vehiculo->kilometraje = $request->km_entrada;
                $vehiculo->marca = $request->marca;
                $vehiculo->fecha = $fechita;
                $vehiculo->save();
    
                $fechaAl = Carbon::parse($request->fechaalta)->format('Y-m-d H:m');
                $generales = new anexosFGenerales();
                $generales->NSolicitud = $clave;
                $generales->FechaAlta = $fechita;
                $generales->OrdenServicio = $os;
                $generales->KmDeIngreso = $request->km_entrada;
                $generales->ClienteYRazonSocial = $request->a;
                $generales->Mail = $request->b;
                $generales->Telefono = $request->c;
                $generales->Conductor = $request->d;
                $generales->Fecha = $fechita;
                $generales->save();
    
                $cotizacion = new anexosForaneos();
                $cotizacion->pVehiculos_id = $vehiculo->id;
                $cotizacion->pGenerales_id = $generales->id;
                $cotizacion->descripcionMO = $request->observaciones;
                $cotizacion->fechaDeVigencia = $fechita;
                $cotizacion->tiempo = '1';
                $cotizacion->importe = '0';
                $cotizacion->observaciones =$request->observaciones;
                $cotizacion->user_id = \Auth::user()->id;
                $cotizacion->ubicacion = $request->usuario;
                $cotizacion->area = '1';
                $cotizacion->empresa_id = $request->empresa_id;
                $cotizacion->eco_id =$request->eco_id;
                $cotizacion->save();   
            }

            if($request->con_id == 1){
                 $prueba= Carbon::now('America/Lima');
                $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
    
    
                $vehiculo1 = new pCFEVehiculos();
                $vehiculo1->identificador = $request->no_economico;
                $vehiculo1->modelo = $request->submarca;
                $vehiculo1->vin =  $request->no_serie;
                $vehiculo1->placas = $request->placas;
                $vehiculo1->ano = $request->modelo;
                $vehiculo1->kilometraje = $request->km_entrada;
                $vehiculo1->marca =  $request->marca;
                $vehiculo1->fecha = $fecha123;
                $vehiculo1->save();

    
                $generales1 = new pCFEGenerales();
                $generales1->NSolicitud = $clave;
                $generales1->FechaAlta = $fecha123;
                $generales1->OrdenServicio =  $os;
                $generales1->KmDeIngreso = $request->km_entrada;
                $generales1->ClienteYRazonSocial = $request->a;
                $generales1->Mail = $request->b;
                $generales1->Telefono = $request->c;
                $generales1->Conductor = $request->d;
                $generales1->Fecha = $fecha123;
                $generales1->save();
    
                $cotizacion = new presupuestosCFE();
                $cotizacion->pCFEVehiculos_id = $vehiculo1->id;
                $cotizacion->pCFEGenerales_id = $generales1->id;
                $cotizacion->descripcionMO = $request->observaciones;
                $cotizacion->fechaDeVigencia = $fecha123;
                $cotizacion->tiempo = '1';
                $cotizacion->importe ='0';
                $cotizacion->observaciones = $request->observaciones;
                $cotizacion->user_id = \Auth::user()->id;
                $cotizacion->ubicacion = $request->usuario;
                $cotizacion->area = 'Area';
                $cotizacion->CFE_id='3';
                $cotizacion->save();   
            }
            if($request->con_id == 2){
                $prueba= Carbon::now('America/Lima');
               $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
   
   
               $vehiculo1 = new pCFEVehiculos();
               $vehiculo1->identificador = $request->no_economico;
                $vehiculo1->modelo = $request->submarca;
                $vehiculo1->vin =  $request->no_serie;
                $vehiculo1->placas = $request->placas;
                $vehiculo1->ano = $request->modelo;
                $vehiculo1->kilometraje = $request->km_entrada;
                $vehiculo1->marca =  $request->marca;
                $vehiculo1->fecha = $fecha123;
               $vehiculo1->save();


   
               $generales1 = new pCFEGenerales();
               $generales1->NSolicitud = $clave;
               $generales1->FechaAlta = $fecha123;
               $generales1->OrdenServicio =  $os;
               $generales1->KmDeIngreso = $request->km_entrada;
               $generales1->ClienteYRazonSocial = $request->a;
               $generales1->Mail = $request->b;
               $generales1->Telefono = $request->c;
               $generales1->Conductor = $request->d;
               $generales1->Fecha = $fecha123;
               $generales1->save();
   
               $cotizacion = new presupuestosCFE();
               $cotizacion->pCFEVehiculos_id = $vehiculo1->id;
               $cotizacion->pCFEGenerales_id = $generales1->id;
               $cotizacion->descripcionMO = $request->observaciones;
               $cotizacion->fechaDeVigencia = $fecha123;
               $cotizacion->tiempo = '1';
               $cotizacion->importe ='0';
               $cotizacion->observaciones = $request->observaciones;
               $cotizacion->user_id = \Auth::user()->id;
               $cotizacion->ubicacion = $request->usuario;
               $cotizacion->area = 'Area';
               $cotizacion->CFE_id='2';
               $cotizacion->save();   
           }

           

            $date = Carbon::now();
            $hora = $date->toTimeString();
            
            $entradasalida = new ESForaneas();
            $entradasalida->empresa = $empresa[0]['nombre'];
            //$entradasalida->n_orden = $request->orden_servicio;
            $entradasalida->n_orden = $clave;
            $entradasalida->hora_entrada = $hora;
            $entradasalida->plaza = $request->usuario;
            $entradasalida->economico = $request->no_economico;
            $entradasalida->placas =  $request->placas;    
            $entradasalida->kms = $request->km_entrada; 
            $entradasalida->serie = $request->no_serie; 
            $entradasalida->fecha_entrada = $fechita; 
            $entradasalida->observaciones = $request->observaciones;    
            $entradasalida->asignado = 'Asignar'; 
            $entradasalida->save();


            $ordenpago = new OrdenesForaneas();
            $ordenpago->fecha =  $fechita; 
            $ordenpago->orden = $request->orden_servicio;
            $ordenpago->empresa = $empresa[0]['nombre'];
            $ordenpago->placa = $request->placas;
            $ordenpago->serie = $request->no_serie;
            $ordenpago->os =  $os;    
            $ordenpago->folio_sistema = $request->usuario;
            $ordenpago->presupuesto =  '1'; 
            $ordenpago->factura = '1'; 
            $ordenpago->monto = '0'; 
            $ordenpago->iva = '0';    
            $ordenpago->total = '0'; 
            $ordenpago->status = 0; 
            $ordenpago->save();

          
           
            DB::commit();
            return [
                'id'=> $anexoFRA->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
  
        if (!$request->ajax()) return redirect('/');

        $fechita = Carbon::parse($request->fecha)->format('Y-m-d');

        $anexoFRA = anexosForaneosRecepcionAcuse::findOrFail($request->id);
        $anexoFRA->empresa_id =  $request->empresa_id;
        $anexoFRA->fecha = $fechita;
        $anexoFRA->no_economico = $request->no_economico;
        $anexoFRA->placas = $request->placas;
        $anexoFRA->marca =$request->marca;
        $anexoFRA->submarca =$request->submarca;
        $anexoFRA->modelo = $request->modelo;;
        $anexoFRA->no_serie =$request->no_serie;
        $anexoFRA->tipo_de_vehiculo =$request->tipo_de_vehiculo;
        $anexoFRA->tipo_de_servicio =$request->tipo_de_servicio;
        $anexoFRA->observaciones =$request->observaciones;
        $anexoFRA->nombre_taller =$request->nombre_taller;
        $anexoFRA->razon_social =$request->razon_social;
        $anexoFRA->usuario =$request->usuario;
        $anexoFRA->rpe =$request->rpe;
        $anexoFRA->km_entrada =$request->km_entrada;
        $anexoFRA->orden_servicio =$request->orden_servicio;
        $anexoFRA->orden_id =$request->orden_id;
        $anexoFRA->ClienteYRazonSocial = $request->a;
        $anexoFRA->Mail = $request->b;
        $anexoFRA->Telefono = $request->c;
        $anexoFRA->Conductor = $request->d;
        $anexoFRA->save();   

        if(\Auth::user()->id == 1){

        if($request->con_id == 1){
            $prueba= Carbon::now('America/Lima');
           $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');


           $vehiculo1 = new pCFEVehiculos();
           $vehiculo1->identificador = $request->no_economico;
           $vehiculo1->modelo = $request->submarca;
           $vehiculo1->vin =  $request->no_serie;
           $vehiculo1->placas = $request->placas;
           $vehiculo1->ano = $request->modelo;
           $vehiculo1->kilometraje = $request->km_entrada;
           $vehiculo1->marca =  $request->marca;
           $vehiculo1->fecha = $fecha123;
           $vehiculo1->save();


           $generales1 = new pCFEGenerales();
           $generales1->NSolicitud = $request->folioNum;
           $generales1->FechaAlta = $fecha123;
           $generales1->OrdenServicio =  $request->orden_servicio;
           $generales1->KmDeIngreso = $request->km_entrada;
           $generales1->ClienteYRazonSocial = $request->a;
           $generales1->Mail = $request->b;
           $generales1->Telefono = $request->c;
           $generales1->Conductor = $request->d;
           $generales1->Fecha = $fecha123;
           $generales1->save();

           $cotizacion = new presupuestosCFE();
           $cotizacion->pCFEVehiculos_id = $vehiculo1->id;
           $cotizacion->pCFEGenerales_id = $generales1->id;
           $cotizacion->descripcionMO = $request->observaciones;
           $cotizacion->fechaDeVigencia = $fecha123;
           $cotizacion->tiempo = '1';
           $cotizacion->importe ='0';
           $cotizacion->observaciones = $request->observaciones;
           $cotizacion->user_id = \Auth::user()->id;
           $cotizacion->ubicacion = $request->usuario;
           $cotizacion->area = 'Area';
           $cotizacion->CFE_id='3';
           $cotizacion->save();   
       }
       if($request->con_id == 2){
           $prueba= Carbon::now('America/Lima');
          $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');


          $vehiculo1 = new pCFEVehiculos();
          $vehiculo1->identificador = $request->no_economico;
           $vehiculo1->modelo = $request->submarca;
           $vehiculo1->vin =  $request->no_serie;
           $vehiculo1->placas = $request->placas;
           $vehiculo1->ano = $request->modelo;
           $vehiculo1->kilometraje = $request->km_entrada;
           $vehiculo1->marca =  $request->marca;
           $vehiculo1->fecha = $fecha123;
          $vehiculo1->save();



          $generales1 = new pCFEGenerales();
          $generales1->NSolicitud = $request->folioNum;
          $generales1->FechaAlta = $fecha123;
          $generales1->OrdenServicio = $request->orden_servicio;
          $generales1->KmDeIngreso = $request->km_entrada;
          $generales1->ClienteYRazonSocial = $request->a;
          $generales1->Mail = $request->b;
          $generales1->Telefono = $request->c;
          $generales1->Conductor = $request->d;
          $generales1->Fecha = $fecha123;
          $generales1->save();

          $cotizacion = new presupuestosCFE();
          $cotizacion->pCFEVehiculos_id = $vehiculo1->id;
          $cotizacion->pCFEGenerales_id = $generales1->id;
          $cotizacion->descripcionMO = $request->observaciones;
          $cotizacion->fechaDeVigencia = $fecha123;
          $cotizacion->tiempo = '1';
          $cotizacion->importe ='0';
          $cotizacion->observaciones = $request->observaciones;
          $cotizacion->user_id = \Auth::user()->id;
          $cotizacion->ubicacion = $request->usuario;
          $cotizacion->area = 'Area';
          $cotizacion->CFE_id='2';
          $cotizacion->save();   
      }
    }

             
       
        return [
            'id'=> $anexoFRA->id
        ];
    }

    public function delete(Request $request){

    
        $sucursal = anexosForaneosRecepcionAcuse::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }

    public function pdfacuse(Request $request,$id){

        $cotizacion = anexosForaneosRecepcionAcuse::join('empresas','anexosFRAcuse.empresa_id','=','empresas.id')
        ->select('anexosFRAcuse.id','empresas.nombre','anexosFRAcuse.empresa_id','anexosFRAcuse.fecha','anexosFRAcuse.no_economico','anexosFRAcuse.placas','anexosFRAcuse.marca','anexosFRAcuse.submarca','anexosFRAcuse.modelo','anexosFRAcuse.no_serie','anexosFRAcuse.tipo_de_vehiculo','anexosFRAcuse.tipo_de_servicio','anexosFRAcuse.observaciones','anexosFRAcuse.nombre_taller','anexosFRAcuse.razon_social','anexosFRAcuse.usuario','anexosFRAcuse.rpe','anexosFRAcuse.km_entrada','anexosFRAcuse.orden_servicio','anexosFRAcuse.orden_id','anexosFRAcuse.folioNum')
        ->where('anexosFRAcuse.id','=',$id)->orderBy('anexosFRAcuse.id', 'desc')->take(1)->get();

        return \View::make('pdf.recepcionAcuse', compact('cotizacion'))->render();
    
    }
}
