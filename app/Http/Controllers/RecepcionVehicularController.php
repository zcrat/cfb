<?php

namespace App\Http\Controllers;

use DateTime;
use App\CondicionesPintura;
use App\EquipoInventario;
use App\ExterioresEquipo;
use App\Empresa;
use App\Http\Requests\General\Validation;
use App\Http\Requests\RecepcionVehicularFormRequest;
use App\InterioresEquipo;
use App\RecepcionVehicular;
use App\Seguro;
use Illuminate\Http\Request;
use App\Vehiculo;
use App\Modelo;
use Illuminate\Support\Carbon;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\TipoAuto;
use App\Marca;
use App\HojaConcepto;
use App\Sucursales;
use App\OrdenesPagadas;
use App\EntradasSalidas;
use App\presupuestos2023;
use App\presupuestos;
use App\presupuestosCFE;
use App\pVehiculos2023;
use App\pGenerales2023;
use App\pVehiculos;
use App\pGenerales;
use App\pCFEVehiculos;
use App\pCFEGenerales;
use App\RecepcionArchivos;
use DB;

class RecepcionVehicularController extends Controller
{

    private function validaciones($request, $camposValidar, $camposPersonalizados)
    {
        return Validator::make(
            $request,
            /** campos a validar */
            $camposValidar,

            /** campos personalizados */
            $camposPersonalizados
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sucu = \Auth::user()->sucursal_id;
        $modulo = $request->modulo;
        $recepcionesResult = collect();
    if($request->orden == '')
        {

        $recepciones = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",'=',$modulo)->orderBy('id', 'desc')->paginate(20);
       
        foreach($recepciones as $recepcion){
            $recepcion->vehiculo;
            $recepcion->vehiculo->marca;
            $recepcion->vehiculo->modelo;
            $recepcion->empresa;
            $recepcionesResult->push($recepcion);
        }
    }
    else 
    {
        $recepciones = RecepcionVehicular::where("folioNum",'=',$request->orden)->orderBy('id', 'desc')->paginate(20);
       
        foreach($recepciones as $recepcion){
            $recepcion->vehiculo;
            $recepcion->vehiculo->marca;
            $recepcion->vehiculo->modelo;
            $recepcion->empresa;
            $recepcionesResult->push($recepcion);
        }
    }
        
        return [
            'pagination' => [
                'total'        => $recepciones->total(),
                'current_page' => $recepciones->currentPage(),
                'per_page'     => $recepciones->perPage(),
                'last_page'    => $recepciones->lastPage(),
                'from'         => $recepciones->firstItem(),
                'to'           => $recepciones->lastItem(),
            ],
            'recepciones' => $recepcionesResult];
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    function base64ToImage($base64_string, $output_file)
    {
        $file = fopen($output_file, "wb");

        $data = explode(',', $base64_string);

        fwrite($file, base64_decode($data[1]));
        fclose($file);

        return $output_file;
    }


    public function store(Request $request)

    {


    
        //Validaciones Recepcion
        $modeloRecepcion = $this->validaciones(
            $request->modeloRecepcion,
            [
                
                'empresa_id' => [
                    'required',
                ],
                'vehiculo_id' => [
                    'required',
                ],
                'orden_seguimiento' => [
                    'required',
                    'regex:(^(' . Validation::texto() . ')$)',
                    'min:1',
                    'max:15'
                ],
                'folio' => [
                    'nullable',
                    'regex:(^(' . Validation::texto() . ')$)',
                    'min:1',
                    'max:15'
                ],
                'notas_adicionales' => [
                    'nullable',
                    'regex:(^(' . Validation::texto() . ')$)',
                    'min:1',
                    'max:120'
                ],
                'indicaciones_del_cliente' => [
                    'nullable',
                    'regex:(^(' . Validation::texto() . ')$)',
                    'min:1',
                    'max:120'
                ],
                'km_entrada' => [
                    'min:1',
                    'max:120'
                ],
                'km_salida' => [
                    'min:1',
                    'max:120'
                ],
                'gas_entrada' => [
                    'required',
                    'regex:(^(' . Validation::texto() . ')$)',
                    'min:1',
                    'max:120'
                ],
                'gas_salida' => [
                    'required',
                    'regex:(^(' . Validation::texto() . ')$)',
                    'min:1',
                    'max:120'
                ],
                'fecha' => [
                    'required',
                ],
                'firma' => [
                    'required'
                ],
                'fecha_compromiso' => [
                    'required'
                ],
            ],
            [
                'vehiculo_id.required' => 'El campo vehículo es obligatorio.',
                'customer_id.required' => 'El campo cliente es obligatorio.',
            ]
        );
        if ($modeloRecepcion->fails()) {
            return response()->json(['errors' => $modeloRecepcion->errors()], 422);
        }
       
       
       

        //Validaciones interiores Equipo
        $modeloInterioresEquipo = new InterioresEquipo();
        $erroresInterioresEquipo = [];
        $modeloClienteInterioresEquipo = $request->modeloInterioresEquipo;
        foreach ($modeloInterioresEquipo->getFillable() as $modeloItem) {
            if ($modeloItem == 'recepcion_vehicular_id') continue;
            //comparar que sea igual o mator a zero;
            if($modeloItem == 'tapetes'){
                if(!isset($modeloClienteInterioresEquipo[$modeloItem])){
                    $erroresInterioresEquipo[$modeloItem][] = "El campo $modeloItem es obligatorio.";
                }
                continue;
            }
            if (!isset($modeloClienteInterioresEquipo[$modeloItem]) || $modeloClienteInterioresEquipo[$modeloItem] == 1) {
                $erroresInterioresEquipo[$modeloItem][] = "Asigne el campo $modeloItem";
            }
        }

       
        if ($erroresInterioresEquipo != []) {
            return response()->json(['errors' => $erroresInterioresEquipo], 422);
        }
       
        //Validaciones exteriores Equipo
        $modeloExterioresEquipo = new ExterioresEquipo();
        
        $erroresExterioresEquipo = [];
        $modeloClienteExterioresEquipo = $request->modeloExterioresEquipo;
        foreach ($modeloExterioresEquipo->getFillable() as $modeloItem) {
            if ($modeloItem == 'recepcion_vehicular_id') continue;
            if (!isset($modeloClienteExterioresEquipo[$modeloItem]) || $modeloClienteExterioresEquipo[$modeloItem] == 1) {
                $erroresExterioresEquipo[$modeloItem][] = "Asigne el campo $modeloItem";
            }
        }
        if ($erroresExterioresEquipo != []) {
            return response()->json(['errors' => $erroresExterioresEquipo], 422);
        }

    
        //Registrar recepcion
       
        $modeloRecepcionTEst = $request->modeloRecepcion;
        $modeloRecepcionTEst['usuario_id'] = \Auth::user()->id; 
        

        $idsucursal = \Auth::user()->sucursal_id;
        $sucu = Sucursales::select('clave')->where('id',$idsucursal)->get();
        $num = RecepcionVehicular::where('sucursal_id','=',$idsucursal)->orderBy('id','desc')->get();
        $numreal = RecepcionVehicular::count();
               
        if($numreal == 0){
            $clave = $sucu[0]['clave'].'00001'; 
        } else {
            if($num[0]['id'] == 0){
                $clave = $sucu[0]['clave'].'00001'; 
            } else {
                $numeros = $num[0]['id'] + 1;
                $numeroConCeros = str_pad($numeros, 5, "0", STR_PAD_LEFT);
                $clave = $sucu[0]['clave'].$numeroConCeros;
            }


        }     
       

        $modeloRecepcionTEst['folioNum'] = $clave; 
        $modeloRecepcionTEst['sucursal_id'] = $idsucursal; 

        //guardar imagen de firma
        $img = $modeloRecepcionTEst['firma'];
        $img2 = $modeloRecepcionTEst['firma2'];
        //$img = str_replace('data:image/png;base64,', '', $img);
        //$img = str_replace(' ', '+', $img);
        //$data = base64_decode($img);
        //$nombreImagen = $modeloRecepcionTEst['customer_id'] . '_' . date("YmdHis");
        //file_put_contents(public_path().'/img/firmas/'.$nombreImagen . '.jpg',$data);
        

        if($img==null){
            $fileName = 'sinlogo.png';
           } else {
            $exploded = explode(',', $img);
    
            $decoded = base64_decode($exploded[1]);
    
        
            $extension = '.png';
    
            $fileName = $modeloRecepcionTEst['customer_id'] . '_' . date("YmdHis").$extension;
    
            $path = public_path().'/img/firmas/'.$fileName;
    
            file_put_contents($path, $decoded);

           
           }

           if($img2==null){
            $fileName2 = 'sinlogo.png';
           } else {
            $exploded2 = explode(',', $img2);
    
            $decoded2 = base64_decode($exploded2[1]);
    
        
            $extension2 = '.png';
    
            $fileName2 = $modeloRecepcionTEst['customer_id'] . '_' . date("YmdHis").$extension2;
    
            $path2 = public_path().'/img/carros/'.$fileName2;
    
            file_put_contents($path2, $decoded2);

           
           }

           $modeloRecepcionTEst['firma'] = $fileName;
           $modeloRecepcionTEst['carro'] = $fileName2;
        
      
        $modeloRecepcionTEst['fecha'] = Carbon::parse($modeloRecepcionTEst['fecha'])->format('Y-m-d H:m');
        $modeloRecepcionTEst['fecha_entrega'] = Carbon::parse($modeloRecepcionTEst['fecha_entrega'])->format('Y-m-d H:m');
        $modeloRecepcionTEst['fecha_compromiso'] = Carbon::parse($modeloRecepcionTEst['fecha_compromiso'])->format('Y-m-d H:m');
       
        
        $recepcionVehicular = RecepcionVehicular::create($modeloRecepcionTEst);

 
        
        if ($recepcionVehicular->id) {
            //Registrar seguro

          
            $modeloSeguro = $request->modeloSeguro;
            $modeloSeguro['recepcion_vehicular_id'] = $recepcionVehicular->id;
            Seguro::create($modeloSeguro);
            
           
            //Registrar Condiciones interiores equipo
            $modeloInterioresEquipo = $request->modeloInterioresEquipo;
            $modeloInterioresEquipo['recepcion_vehicular_id'] = $recepcionVehicular->id;
            InterioresEquipo::create($modeloInterioresEquipo);
            
            //Registrar Condiciones exteriores equipo
            $modeloExterioresEquipo = $request->modeloExterioresEquipo;
            $modeloExterioresEquipo['recepcion_vehicular_id'] = $recepcionVehicular->id;
            ExterioresEquipo::create($modeloExterioresEquipo);
           
           
            //Registrar equipo inventario
            $inventario = new EquipoInventario();
            $datosEquipoInventario = [];
            $datosEquipoInventario['recepcion_vehicular_id'] = $recepcionVehicular->id;
            $equipoInventario = $request->modeloEquipoInventario;
            foreach ($inventario->getFillable() as $modeloItem) {
                if ($modeloItem == 'recepcion_vehicular_id') continue;
                $filaEncontrada = false;
                foreach ($equipoInventario as $filadbclient => $value) {
                    if ($modeloItem == $filadbclient) {
                        $datosEquipoInventario[$modeloItem] = true;
                        $filaEncontrada = true;
                        break;
                    }
                }
                if (!$filaEncontrada) {
                    $datosEquipoInventario[$modeloItem] = false;
                }
            }
            EquipoInventario::create($datosEquipoInventario);
           
            //Registrar condiciones pintura
            $condicionesPintura = new CondicionesPintura();
            $datosCondicionesPintura = [];
            $datosCondicionesPintura['recepcion_vehicular_id'] = $recepcionVehicular->id;
            $condicionesPinturaModeloCliente = $request->modeloCondicionesPintura;
            foreach ($condicionesPintura->getFillable() as $modeloItem) {
                if ($modeloItem == 'recepcion_vehicular_id') continue;
                $filaEncontrada = false;
                foreach ($condicionesPinturaModeloCliente as $filadbclient => $value) {
                    if ($modeloItem == $filadbclient) {
                        $datosCondicionesPintura[$modeloItem] = true;
                        $filaEncontrada = true;
                        break;
                    }
                }
                if (!$filaEncontrada) {
                    $datosCondicionesPintura[$modeloItem] = false;
                }
            }
            CondicionesPintura::create($datosCondicionesPintura);
      
            

            $fechita = Carbon::parse($recepcionVehicular->fecha)->format('Y-m-d');
            $vehiculo = Vehiculo::where('id','=',$recepcionVehicular->vehiculo_id)->get();
            $empresa = Empresa::where('id','=',$recepcionVehicular->empresa_id)->get();
            $modelo = Modelo::where('id','=',$vehiculo[0]['modelo_id'])->get();
            $marca = Marca::where('id','=',$vehiculo[0]['marca_id'])->get();

            $date = Carbon::now();
            $hora = $date->toTimeString();

            

            $entradasalida = new EntradasSalidas();
            $entradasalida->empresa = $empresa[0]->nombre;
            $entradasalida->n_orden = $recepcionVehicular->orden_seguimiento;
            $entradasalida->hora_entrada = $hora;
            $entradasalida->orden_servicio = $recepcionVehicular->orden_seguimiento;
            $entradasalida->economico = $vehiculo[0]->no_economico;
            $entradasalida->placas =  $vehiculo[0]->placas;    
            $entradasalida->kms = $recepcionVehicular->km_entrada; 
            $entradasalida->serie = $vehiculo[0]->vim;
            $entradasalida->fecha_entrada = $fechita;  
            $entradasalida->observaciones = $recepcionVehicular->indicaciones_del_cliente; 
            $entradasalida->asignado = $recepcionVehicular->tecnico;
            $entradasalida->save();

            $ordenpago = new OrdenesPagadas();
            $ordenpago->fecha =  $fechita;
            $ordenpago->orden = $recepcionVehicular->orden_seguimiento;
            $ordenpago->empresa = $empresa[0]->nombre;
            $ordenpago->placa = $vehiculo[0]->placas;    
            $ordenpago->serie = $vehiculo[0]->vim;
            $ordenpago->os =  $recepcionVehicular->orden_seguimiento;    
            $ordenpago->folio_sistema = $recepcionVehicular->folioNum;  
            $ordenpago->status = 0; 
            $ordenpago->save();

            if($modeloRecepcionTEst['modulo'] == 7){


                $prueba= Carbon::now('America/Lima');
                $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
    
    
                $vehiculo1 = new pVehiculos2023();
                $vehiculo1->identificador = $vehiculo[0]->no_economico;
                $vehiculo1->modelo = $modelo[0]->nombre;
                $vehiculo1->vin =  $vehiculo[0]->vim;
                $vehiculo1->placas = $vehiculo[0]->placas;
                $vehiculo1->ano = $vehiculo[0]->anio;
                $vehiculo1->kilometraje = $recepcionVehicular->km_entrada;
                $vehiculo1->marca = $marca[0]->nombre;
                $vehiculo1->fecha = $fecha123;
                $vehiculo1->save();
    
                $generales1 = new pGenerales2023();
                $generales1->NSolicitud = $recepcionVehicular->folioNum;
                $generales1->FechaAlta = $fecha123;
                $generales1->OrdenServicio = $recepcionVehicular->orden_seguimiento;
                $generales1->KmDeIngreso = $recepcionVehicular->km_entrada;
                $generales1->ClienteYRazonSocial = $empresa[0]->nombre;
                $generales1->Mail = $empresa[0]->email;
                $generales1->Telefono = $empresa[0]->tel_negocio;
                $generales1->Conductor = 'Conductor';
                $generales1->Fecha = $fecha123;
                $generales1->save();
    
                $cotizacion = new presupuestos2023();
                $cotizacion->pVehiculos_id = $vehiculo1->id;
                $cotizacion->pGenerales_id = $generales1->id;
                $cotizacion->descripcionMO = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->fechaDeVigencia = $fecha123;
                $cotizacion->tiempo = '1';
                $cotizacion->importe ='0';
                $cotizacion->observaciones = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->user_id = \Auth::user()->id;
                $cotizacion->ubicacion = 'Ubicacion';
                $cotizacion->area = 'Area';
                $cotizacion->empresa_id = $recepcionVehicular->empresa_id;
                $cotizacion->eco_id ='1';
                $cotizacion->save();   

                $HojaConcepto = new HojaConcepto;
                $HojaConcepto->modulo                       = $modeloRecepcionTEst['modulo'];
                $HojaConcepto->presupuesto_id               = $cotizacion->id;
                $HojaConcepto->id_recepcion                 = $recepcionVehicular->id;
                $HojaConcepto->id_tecnico                   = $recepcionVehicular->tecnico;
                $HojaConcepto->odes                         = $recepcionVehicular->folioNum;
                $HojaConcepto->r_r                          = $recepcionVehicular->orden_seguimiento;
                $HojaConcepto->fecha_hoja_concepto          = Carbon::parse($fecha123)->timezone('America/Mexico_City')->toDateTimeString();
                $HojaConcepto->subtotal_partes              = '0';
                $HojaConcepto->subtotal_mano_obra           = '0';
                $HojaConcepto->subtotal_subcontratado       = '0';
                $HojaConcepto->subtotal_otros               = '0';
                $HojaConcepto->subtotal_subtotal_costos     = '0';
                $HojaConcepto->iva_subtotal_partes          = '0';
                $HojaConcepto->iva_subtotal_mano_obra       = '0';
                $HojaConcepto->iva_subtotal_subcontratado   = '0';
                $HojaConcepto->iva_subtotal_otros           = '0';
                $HojaConcepto->iva_subtotal_subtotal_costos = '0';
                $HojaConcepto->total_partes                 = '0';
                $HojaConcepto->total_mano_obra              = '0';
                $HojaConcepto->total_subcontratado          = '0';
                $HojaConcepto->total_otros                  = '0';
                $HojaConcepto->total_subtotal_costos        = '0';
                $HojaConcepto->autorizacion                 = '';
                $HojaConcepto->save();

            }
            if($modeloRecepcionTEst['modulo'] == 5){


                $prueba= Carbon::now('America/Lima');
                $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
    
    
                $vehiculo1 = new pVehiculos2023();
                $vehiculo1->identificador = $vehiculo[0]->no_economico;
                $vehiculo1->modelo = $modelo[0]->nombre;
                $vehiculo1->vin =  $vehiculo[0]->vim;
                $vehiculo1->placas = $vehiculo[0]->placas;
                $vehiculo1->ano = $vehiculo[0]->anio;
                $vehiculo1->kilometraje = $recepcionVehicular->km_entrada;
                $vehiculo1->marca = $marca[0]->nombre;
                $vehiculo1->fecha = $fecha123;
                $vehiculo1->save();
    
                $generales1 = new pGenerales2023();
                $generales1->NSolicitud = $recepcionVehicular->folioNum;
                $generales1->FechaAlta = $fecha123;
                $generales1->OrdenServicio = $recepcionVehicular->orden_seguimiento;
                $generales1->KmDeIngreso = $recepcionVehicular->km_entrada;
                $generales1->ClienteYRazonSocial = $empresa[0]->nombre;
                $generales1->Mail = $empresa[0]->email;
                $generales1->Telefono = $empresa[0]->tel_negocio;
                $generales1->Conductor = 'Conductor';
                $generales1->Fecha = $fecha123;
                $generales1->save();
    
                $cotizacion = new presupuestos2023();
                $cotizacion->pVehiculos_id = $vehiculo1->id;
                $cotizacion->pGenerales_id = $generales1->id;
                $cotizacion->descripcionMO = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->fechaDeVigencia = $fecha123;
                $cotizacion->tiempo = '1';
                $cotizacion->importe ='0';
                $cotizacion->observaciones = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->user_id = \Auth::user()->id;
                $cotizacion->ubicacion = 'Ubicacion';
                $cotizacion->area = 'Area';
                $cotizacion->empresa_id = $recepcionVehicular->empresa_id;
                $cotizacion->save();   

                $HojaConcepto = new HojaConcepto;
                $HojaConcepto->modulo                       = $modeloRecepcionTEst['modulo'];
                $HojaConcepto->presupuesto_id               = $cotizacion->id;
                $HojaConcepto->id_recepcion                 = $recepcionVehicular->id;
                $HojaConcepto->id_tecnico                   = $recepcionVehicular->tecnico;
                $HojaConcepto->odes                         = $recepcionVehicular->folioNum;
                $HojaConcepto->r_r                          = $recepcionVehicular->orden_seguimiento;
                $HojaConcepto->fecha_hoja_concepto          = Carbon::parse($fecha123)->timezone('America/Mexico_City')->toDateTimeString();
                $HojaConcepto->subtotal_partes              = '0';
                $HojaConcepto->subtotal_mano_obra           = '0';
                $HojaConcepto->subtotal_subcontratado       = '0';
                $HojaConcepto->subtotal_otros               = '0';
                $HojaConcepto->subtotal_subtotal_costos     = '0';
                $HojaConcepto->iva_subtotal_partes          = '0';
                $HojaConcepto->iva_subtotal_mano_obra       = '0';
                $HojaConcepto->iva_subtotal_subcontratado   = '0';
                $HojaConcepto->iva_subtotal_otros           = '0';
                $HojaConcepto->iva_subtotal_subtotal_costos = '0';
                $HojaConcepto->total_partes                 = '0';
                $HojaConcepto->total_mano_obra              = '0';
                $HojaConcepto->total_subcontratado          = '0';
                $HojaConcepto->total_otros                  = '0';
                $HojaConcepto->total_subtotal_costos        = '0';
                $HojaConcepto->autorizacion                 = '';
                $HojaConcepto->save();

            }

            if($modeloRecepcionTEst['modulo'] == 4){


                $prueba= Carbon::now('America/Lima');
                $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
    
    
                $vehiculo1 = new pVehiculos();
                $vehiculo1->identificador = $vehiculo[0]->no_economico;
                $vehiculo1->modelo = $modelo[0]->nombre;
                $vehiculo1->vin =  $vehiculo[0]->vim;
                $vehiculo1->placas = $vehiculo[0]->placas;
                $vehiculo1->ano = $vehiculo[0]->anio;
                $vehiculo1->kilometraje = $recepcionVehicular->km_entrada;
                $vehiculo1->marca = $marca[0]->nombre;
                $vehiculo1->fecha = $fecha123;
                $vehiculo1->save();
    
                $generales1 = new pGenerales();
                $generales1->NSolicitud = $recepcionVehicular->folioNum;
                $generales1->FechaAlta = $fecha123;
                $generales1->OrdenServicio = $recepcionVehicular->orden_seguimiento;
                $generales1->KmDeIngreso = $recepcionVehicular->km_entrada;
                $generales1->ClienteYRazonSocial = $empresa[0]->nombre;
                $generales1->Mail = $empresa[0]->email;
                $generales1->Telefono = $empresa[0]->tel_negocio;
                $generales1->Conductor = 'Conductor';
                $generales1->Fecha = $fecha123;
                $generales1->save();
    
                $cotizacion = new presupuestos();
                $cotizacion->pVehiculos_id = $vehiculo1->id;
                $cotizacion->pGenerales_id = $generales1->id;
                $cotizacion->descripcionMO = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->fechaDeVigencia = $fecha123;
                $cotizacion->tiempo = '1';
                $cotizacion->importe ='0';
                $cotizacion->observaciones = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->user_id = \Auth::user()->id;
                $cotizacion->ubicacion = 'Ubicacion';
                $cotizacion->area = 'Area';
                $cotizacion->empresa_id = $recepcionVehicular->empresa_id;
                $cotizacion->save();   

                $HojaConcepto = new HojaConcepto;
                $HojaConcepto->modulo                       = $modeloRecepcionTEst['modulo'];
                $HojaConcepto->presupuesto_id               = $cotizacion->id;
                $HojaConcepto->id_recepcion                 = $recepcionVehicular->id;
                $HojaConcepto->id_tecnico                   = $recepcionVehicular->tecnico;
                $HojaConcepto->odes                         = $recepcionVehicular->folioNum;
                $HojaConcepto->r_r                          = $recepcionVehicular->orden_seguimiento;
                $HojaConcepto->fecha_hoja_concepto          = Carbon::parse($fecha123)->timezone('America/Mexico_City')->toDateTimeString();
                $HojaConcepto->subtotal_partes              = '0';
                $HojaConcepto->subtotal_mano_obra           = '0';
                $HojaConcepto->subtotal_subcontratado       = '0';
                $HojaConcepto->subtotal_otros               = '0';
                $HojaConcepto->subtotal_subtotal_costos     = '0';
                $HojaConcepto->iva_subtotal_partes          = '0';
                $HojaConcepto->iva_subtotal_mano_obra       = '0';
                $HojaConcepto->iva_subtotal_subcontratado   = '0';
                $HojaConcepto->iva_subtotal_otros           = '0';
                $HojaConcepto->iva_subtotal_subtotal_costos = '0';
                $HojaConcepto->total_partes                 = '0';
                $HojaConcepto->total_mano_obra              = '0';
                $HojaConcepto->total_subcontratado          = '0';
                $HojaConcepto->total_otros                  = '0';
                $HojaConcepto->total_subtotal_costos        = '0';
                $HojaConcepto->autorizacion                 = '';
                $HojaConcepto->save();

            }

            if($modeloRecepcionTEst['modulo'] == 3){


                $prueba= Carbon::now('America/Lima');
                $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
    
    
                $vehiculo1 = new pCFEVehiculos();
                $vehiculo1->identificador = $vehiculo[0]->no_economico;
                $vehiculo1->modelo = $modelo[0]->nombre;
                $vehiculo1->vin =  $vehiculo[0]->vim;
                $vehiculo1->placas = $vehiculo[0]->placas;
                $vehiculo1->ano = $vehiculo[0]->anio;
                $vehiculo1->kilometraje = $recepcionVehicular->km_entrada;
                $vehiculo1->marca = $marca[0]->nombre;
                $vehiculo1->fecha = $fecha123;
                $vehiculo1->save();

    
                $generales1 = new pCFEGenerales();
                $generales1->NSolicitud = $recepcionVehicular->folioNum;
                $generales1->FechaAlta = $fecha123;
                $generales1->OrdenServicio = $recepcionVehicular->orden_seguimiento;
                $generales1->KmDeIngreso = $recepcionVehicular->km_entrada;
                $generales1->ClienteYRazonSocial = $empresa[0]->nombre;
                $generales1->Mail = $empresa[0]->email;
                $generales1->Telefono = $empresa[0]->tel_negocio;
                $generales1->Conductor = 'Conductor';
                $generales1->Fecha = $fecha123;
                $generales1->save();
    
                $cotizacion = new presupuestosCFE();
                $cotizacion->pCFEVehiculos_id = $vehiculo1->id;
                $cotizacion->pCFEGenerales_id = $generales1->id;
                $cotizacion->descripcionMO = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->fechaDeVigencia = $fecha123;
                $cotizacion->tiempo = '1';
                $cotizacion->importe ='0';
                $cotizacion->observaciones = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->user_id = \Auth::user()->id;
                $cotizacion->ubicacion = 'Ubicacion';
                $cotizacion->area = 'Area';
                $cotizacion->CFE_id='3';
                $cotizacion->save();   


                $HojaConcepto = new HojaConcepto;
                $HojaConcepto->modulo                       = $modeloRecepcionTEst['modulo'];
                $HojaConcepto->presupuesto_id               = $cotizacion->id;
                $HojaConcepto->id_recepcion                 = $recepcionVehicular->id;
                $HojaConcepto->id_tecnico                   = $recepcionVehicular->tecnico;
                $HojaConcepto->odes                         = $recepcionVehicular->folioNum;
                $HojaConcepto->r_r                          = $recepcionVehicular->orden_seguimiento;
                $HojaConcepto->fecha_hoja_concepto          = Carbon::parse($fecha123)->timezone('America/Mexico_City')->toDateTimeString();
                $HojaConcepto->subtotal_partes              = '0';
                $HojaConcepto->subtotal_mano_obra           = '0';
                $HojaConcepto->subtotal_subcontratado       = '0';
                $HojaConcepto->subtotal_otros               = '0';
                $HojaConcepto->subtotal_subtotal_costos     = '0';
                $HojaConcepto->iva_subtotal_partes          = '0';
                $HojaConcepto->iva_subtotal_mano_obra       = '0';
                $HojaConcepto->iva_subtotal_subcontratado   = '0';
                $HojaConcepto->iva_subtotal_otros           = '0';
                $HojaConcepto->iva_subtotal_subtotal_costos = '0';
                $HojaConcepto->total_partes                 = '0';
                $HojaConcepto->total_mano_obra              = '0';
                $HojaConcepto->total_subcontratado          = '0';
                $HojaConcepto->total_otros                  = '0';
                $HojaConcepto->total_subtotal_costos        = '0';
                $HojaConcepto->autorizacion                 = '';
                $HojaConcepto->save();

            }

            if($modeloRecepcionTEst['modulo'] == 2){


                $prueba= Carbon::now('America/Lima');
                $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
    
    
                $vehiculo1 = new pCFEVehiculos();
                $vehiculo1->identificador = $vehiculo[0]->no_economico;
                $vehiculo1->modelo = $modelo[0]->nombre;
                $vehiculo1->vin =  $vehiculo[0]->vim;
                $vehiculo1->placas = $vehiculo[0]->placas;
                $vehiculo1->ano = $vehiculo[0]->anio;
                $vehiculo1->kilometraje = $recepcionVehicular->km_entrada;
                $vehiculo1->marca = $marca[0]->nombre;
                $vehiculo1->fecha = $fecha123;
                $vehiculo1->save();
    
                $generales1 = new pCFEGenerales();
                $generales1->NSolicitud = $recepcionVehicular->folioNum;
                $generales1->FechaAlta = $fecha123;
                $generales1->OrdenServicio = $recepcionVehicular->orden_seguimiento;
                $generales1->KmDeIngreso = $recepcionVehicular->km_entrada;
                $generales1->ClienteYRazonSocial = $empresa[0]->nombre;
                $generales1->Mail = $empresa[0]->email;
                $generales1->Telefono = $empresa[0]->tel_negocio;
                $generales1->Conductor = 'Conductor';
                $generales1->Fecha = $fecha123;
                $generales1->save();
    
                $cotizacion = new presupuestosCFE();
                $cotizacion->pCFEVehiculos_id = $vehiculo1->id;
                $cotizacion->pCFEGenerales_id = $generales1->id;
                $cotizacion->descripcionMO = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->fechaDeVigencia = $fecha123;
                $cotizacion->tiempo = '1';
                $cotizacion->importe ='0';
                $cotizacion->observaciones = $recepcionVehicular->indicaciones_del_cliente;
                $cotizacion->user_id = \Auth::user()->id;
                $cotizacion->ubicacion = 'Ubicacion';
                $cotizacion->area = 'Area';
                $cotizacion->CFE_id='2';
                $cotizacion->save();   


                $HojaConcepto = new HojaConcepto;
                $HojaConcepto->modulo                       = $modeloRecepcionTEst['modulo'];
                $HojaConcepto->presupuesto_id               = $cotizacion->id;
                $HojaConcepto->id_recepcion                 = $recepcionVehicular->id;
                $HojaConcepto->id_tecnico                   = $recepcionVehicular->tecnico;
                $HojaConcepto->odes                         = $recepcionVehicular->folioNum;
                $HojaConcepto->r_r                          = $recepcionVehicular->orden_seguimiento;
                $HojaConcepto->fecha_hoja_concepto          = Carbon::parse($fecha123)->timezone('America/Mexico_City')->toDateTimeString();
                $HojaConcepto->subtotal_partes              = '0';
                $HojaConcepto->subtotal_mano_obra           = '0';
                $HojaConcepto->subtotal_subcontratado       = '0';
                $HojaConcepto->subtotal_otros               = '0';
                $HojaConcepto->subtotal_subtotal_costos     = '0';
                $HojaConcepto->iva_subtotal_partes          = '0';
                $HojaConcepto->iva_subtotal_mano_obra       = '0';
                $HojaConcepto->iva_subtotal_subcontratado   = '0';
                $HojaConcepto->iva_subtotal_otros           = '0';
                $HojaConcepto->iva_subtotal_subtotal_costos = '0';
                $HojaConcepto->total_partes                 = '0';
                $HojaConcepto->total_mano_obra              = '0';
                $HojaConcepto->total_subcontratado          = '0';
                $HojaConcepto->total_otros                  = '0';
                $HojaConcepto->total_subtotal_costos        = '0';
                $HojaConcepto->autorizacion                 = '';
                $HojaConcepto->save();

            }
            


            return ['estado' => true];


        }
        return ['estado' => false];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RecepcionVehicular $recepcionVehicular
     * @return \Illuminate\Http\Response
     */
    public function show(RecepcionVehicular $recepcionVehicular)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RecepcionVehicular $recepcionVehicular
     * @return \Illuminate\Http\Response
     */
    public function edit($idRecepcion, RecepcionVehicular $recepcionVehicular)
    {
        
        $RecepcionVehicular = new RecepcionVehicular();
        $InterioresEquipo = new InterioresEquipo();
        $ExterioresEquipo = new ExterioresEquipo();
        $Seguro = new Seguro();
        $EquipoInventario = new EquipoInventario();
        $CondicionesPintura = new CondicionesPintura();


        $modeloRecepcion = $RecepcionVehicular->where('id', '=', $idRecepcion)->take(1)->get();
        $modeloInterioresEquipo = $InterioresEquipo->where('recepcion_vehicular_id', '=', $idRecepcion)->take(1)->get();
        $modeloExterioresEquipo = $ExterioresEquipo->where('recepcion_vehicular_id', '=', $idRecepcion)->take(1)->get();
        $modeloSeguro = $Seguro->where('recepcion_vehicular_id', '=', $idRecepcion)->take(1)->get();
        $modeloEquipoInventario = $EquipoInventario->where('recepcion_vehicular_id', '=', $idRecepcion)->take(1)->get();
        $modeloCondicionesPintura = $CondicionesPintura->where('recepcion_vehicular_id', '=', $idRecepcion)->take(1)->get();
        
        $fecha = new DateTime($modeloRecepcion[0]->fecha);
        $modeloRecepcion[0]->fecha = $fecha->format('Y-m-d\Th:i:s\Z');

        $fecha_compromiso = new DateTime($modeloRecepcion[0]->fecha_compromiso);
        $modeloRecepcion[0]->fecha_compromiso = $fecha_compromiso->format('Y-m-d\Th:i:s\Z');

        $data = [
            'modeloRecepcion' => $modeloRecepcion,
            'modeloInterioresEquipo' => $modeloInterioresEquipo,
            'modeloExterioresEquipo' => $modeloExterioresEquipo,
            'modeloSeguro' => $modeloSeguro,
            'modeloEquipoInventario' => $modeloEquipoInventario,
            'modeloCondicionesPintura' => $modeloCondicionesPintura,
        ];

        return $data;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\RecepcionVehicular $recepcionVehicular
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, RecepcionVehicular $recepcionVehicular)
    {   
        $Seguro = new Seguro();  
        $InterioresEquipo = new InterioresEquipo();
        

        if($request->modeloRecepcion){
            $recepcionVehicular = $recepcionVehicular->find($request->modeloRecepcion['id']);

            $recepcionVehicular->usuario_id = $request->modeloRecepcion['usuario_id'];
            $recepcionVehicular->empresa_id = $request->modeloRecepcion['empresa_id']['code'];
            $recepcionVehicular->vehiculo_id = $request->modeloRecepcion['vehiculo_id']['code'];
            $recepcionVehicular->orden_seguimiento = $request->modeloRecepcion['orden_seguimiento'];
            $recepcionVehicular->folio = $request->modeloRecepcion['folio'];
            $recepcionVehicular->notas_adicionales = $request->modeloRecepcion['notas_adicionales'];
            $recepcionVehicular->indicaciones_del_cliente = $request->modeloRecepcion['indicaciones_del_cliente'];
            $recepcionVehicular->km_entrada = $request->modeloRecepcion['km_entrada'];
            $recepcionVehicular->km_salida = $request->modeloRecepcion['km_salida'];
            $recepcionVehicular->gas_entrada = $request->modeloRecepcion['gas_entrada'];
            $recepcionVehicular->gas_salida = $request->modeloRecepcion['gas_salida'];
            $recepcionVehicular->tecnico = $request->modeloRecepcion['tecnico'];
            $recepcionVehicular->fecha = Carbon::parse($request->modeloRecepcion['fecha'])->timezone('America/Mexico_City')->toDateTimeString();
            $recepcionVehicular->fecha_entrega = Carbon::parse($request->modeloRecepcion['fecha_entrega'])->timezone('America/Mexico_City')->toDateTimeString();
            if($request->modeloRecepcion['firma'] != 'no firma' ){
                $recepcionVehicular->firma = $request->modeloRecepcion['firma'];
            }
            $recepcionVehicular->fecha_compromiso = Carbon::parse($request->modeloRecepcion['fecha_compromiso'])->timezone('America/Mexico_City')->toDateTimeString();
            $recepcionVehicular->save();
        }
        
        
        if($request->modeloSeguro){
            $Seguro = $Seguro->find($request->modeloSeguro['id']);
            $Seguro->recepcion_vehicular_id = $request->modeloSeguro['recepcion_vehicular_id'];
            $Seguro->cia_seg = $request->modeloSeguro['cia_seg'];
            $Seguro->tel_seg = $request->modeloSeguro['tel_seg'];
            $Seguro->no_siniestro = $request->modeloSeguro['no_siniestro'];
            $Seguro->ajustador = $request->modeloSeguro['ajustador'];
            $Seguro->save();

        }

        if($request->modeloInterioresEquipo){
            $InterioresEquipo = $InterioresEquipo->find($request->modeloInterioresEquipo['id']);
            $InterioresEquipo->recepcion_vehicular_id = $request->modeloInterioresEquipo['recepcion_vehicular_id'];
            $InterioresEquipo->puerta_interior_frontal = $request->modeloInterioresEquipo['puerta_interior_frontal'];
            $InterioresEquipo->puerta_interior_trasera = $request->modeloInterioresEquipo['puerta_interior_trasera'];
            $InterioresEquipo->puerta_delantera_frontal = $request->modeloInterioresEquipo['puerta_delantera_frontal'];
            $InterioresEquipo->puerta_delantera_trasera = $request->modeloInterioresEquipo['puerta_delantera_trasera'];
            $InterioresEquipo->asiento_interior_frontal = $request->modeloInterioresEquipo['asiento_interior_frontal'];
            $InterioresEquipo->asiento_interior_trasera = $request->modeloInterioresEquipo['asiento_interior_trasera'];
            $InterioresEquipo->asiento_delantera_frontal = $request->modeloInterioresEquipo['asiento_delantera_frontal'];
            $InterioresEquipo->asiento_delantera_trasera = $request->modeloInterioresEquipo['asiento_delantera_trasera'];
            $InterioresEquipo->consola_central = $request->modeloInterioresEquipo['consola_central'];
            $InterioresEquipo->claxon = $request->modeloInterioresEquipo['claxon'];
            $InterioresEquipo->tablero = $request->modeloInterioresEquipo['tablero'];
            $InterioresEquipo->quemacocos = $request->modeloInterioresEquipo['quemacocos'];
            $InterioresEquipo->toldo = $request->modeloInterioresEquipo['toldo'];
            $InterioresEquipo->elevadores_eletricos = $request->modeloInterioresEquipo['elevadores_eletricos'];
            $InterioresEquipo->luces_interiores = $request->modeloInterioresEquipo['luces_interiores'];
            $InterioresEquipo->seguros_eletricos = $request->modeloInterioresEquipo['seguros_eletricos'];
            $InterioresEquipo->tapetes = $request->modeloInterioresEquipo['tapetes'];
            $InterioresEquipo->climatizador = $request->modeloInterioresEquipo['climatizador'];
            $InterioresEquipo->radio = $request->modeloInterioresEquipo['radio'];
            $InterioresEquipo->espejos_retrovizor = $request->modeloInterioresEquipo['espejos_retrovizor'];
            $InterioresEquipo->save();
        }
        if($request->modeloExterioresEquipo){
            $ExterioresEquipo = new ExterioresEquipo();
            $ExterioresEquipo = $ExterioresEquipo->find($request->modeloExterioresEquipo['id']);
            $ExterioresEquipo->recepcion_vehicular_id = $request->modeloExterioresEquipo['recepcion_vehicular_id'];
            $ExterioresEquipo->antena_radio = $request->modeloExterioresEquipo['antena_radio']; 
            $ExterioresEquipo->antena_telefono = $request->modeloExterioresEquipo['antena_telefono'];
            $ExterioresEquipo->antena_cb = $request->modeloExterioresEquipo['antena_cb'];
            $ExterioresEquipo->estribos = $request->modeloExterioresEquipo['estribos'];
            $ExterioresEquipo->espejos_laterales = $request->modeloExterioresEquipo['espejos_laterales'];
            $ExterioresEquipo->guardafangos = $request->modeloExterioresEquipo['guardafangos'];
            $ExterioresEquipo->parabrisas = $request->modeloExterioresEquipo['parabrisas'];
            $ExterioresEquipo->sistema_alarma = $request->modeloExterioresEquipo['sistema_alarma'];
            $ExterioresEquipo->limpia_parabrisas = $request->modeloExterioresEquipo['limpia_parabrisas'];
            $ExterioresEquipo->luces_exteriores = $request->modeloExterioresEquipo['luces_exteriores'];
            $ExterioresEquipo->save();

        }
        if($request->modeloEquipoInventario){
            $EquipoInventario = new EquipoInventario();
            $EquipoInventario = $EquipoInventario->find($request->modeloEquipoInventario['id']);
            $EquipoInventario->llanta = ($request->modeloEquipoInventario['llanta'] == 'accepted') ? 1 : 0;
            $EquipoInventario->cubreruedas = ($request->modeloEquipoInventario['cubreruedas'] == 'accepted') ? 1 : 0;
            $EquipoInventario->cables_corriente = ($request->modeloEquipoInventario['cables_corriente'] == 'accepted') ? 1 : 0;
            $EquipoInventario->candado_ruedas = ($request->modeloEquipoInventario['candado_ruedas'] == 'accepted') ? 1 : 0;
            $EquipoInventario->estuche_herramientas = ($request->modeloEquipoInventario['estuche_herramientas'] == 'accepted') ? 1 : 0;
            $EquipoInventario->gato = ($request->modeloEquipoInventario['gato'] == 'accepted') ? 1 : 0;
            $EquipoInventario->llave_tuercas = ($request->modeloEquipoInventario['llave_tuercas'] == 'accepted') ? 1 : 0;
            $EquipoInventario->tarjeta_circulacion = ($request->modeloEquipoInventario['tarjeta_circulacion']) == 'accepted' ? 1 : 0;
            $EquipoInventario->triangulo_seguridad = ($request->modeloEquipoInventario['triangulo_seguridad']) == 'accepted' ? 1 : 0;
            $EquipoInventario->extinguidor = ($request->modeloEquipoInventario['triangulo_seguridad'] == 'accepted') ? 1 : 0;
            $EquipoInventario->placas = ($request->modeloEquipoInventario['placas'] == 'accepted') ? 1 : 0;
            $EquipoInventario->save();        

        }

        if($request->modeloCondicionesPintura){
            $CondicionesPintura = new CondicionesPintura();
            $CondicionesPintura = $CondicionesPintura->find($request->modeloCondicionesPintura['id']);
            $CondicionesPintura->decolorada = ($request->modeloCondicionesPintura['decolorada'] == 'accepted') ? 1 : 0;
            $CondicionesPintura->emblemas_completos = ($request->modeloCondicionesPintura['emblemas_completos'] == 'accepted') ? 1 : 0;
            $CondicionesPintura->color_no_igual = ($request->modeloCondicionesPintura['color_no_igual'] == 'accepted') ? 1 : 0;
            $CondicionesPintura->logos = ($request->modeloCondicionesPintura['logos'] == 'accepted') ? 1 : 0;
            $CondicionesPintura->exeso_rayones = ($request->modeloCondicionesPintura['exeso_rayones'] == 'accepted') ? 1 : 0;
            $CondicionesPintura->exeso_rociado = ($request->modeloCondicionesPintura['exeso_rociado'] == 'accepted') ? 1 : 0;
            $CondicionesPintura->pequenias_grietas = ($request->modeloCondicionesPintura['pequenias_grietas'] == 'accepted') ? 1 : 0;
            $CondicionesPintura->danios_granizado = ($request->modeloCondicionesPintura['danios_granizado']) == 'accepted' ? 1 : 0;
            $CondicionesPintura->carroceria_golpes = ($request->modeloCondicionesPintura['carroceria_golpes']) == 'accepted' ? 1 : 0;
            $CondicionesPintura->lluvia_acido = ($request->modeloCondicionesPintura['lluvia_acido'] == 'accepted') ? 1 : 0;
            $res = $CondicionesPintura->save();
        }
        
        if ($res) {
            return ['estado' => true];
        }
        return ['estado' => false];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RecepcionVehicular $recepcionVehicular
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecepcionVehicular $recepcionVehicular)
    {
        //
    }

    public function reporte(Request $request,$id){

        

        $Recepcion = RecepcionVehicular::where('recepcion_vehicular.id','=',$id)
        ->select('recepcion_vehicular.customer_id')
            ->first();


       if($Recepcion->customer_id==null){
        $RecepcionVehicular = RecepcionVehicular::join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
        ->join('users','recepcion_vehicular.usuario_id','=','users.id')
        ->join('vehiculos','recepcion_vehicular.vehiculo_id','=','vehiculos.id')
        ->join('tipo_auto','vehiculos.tipo_id','=','tipo_auto.id')
        ->join('marcas','vehiculos.marca_id','=','marcas.id')
        ->join('modelos','vehiculos.modelo_id','=','modelos.id')
        ->join('colores','vehiculos.color_id','=','colores.id')
        ->select('recepcion_vehicular.id','recepcion_vehicular.orden_seguimiento','recepcion_vehicular.folio','recepcion_vehicular.notas_adicionales',
        'recepcion_vehicular.indicaciones_del_cliente','recepcion_vehicular.km_entrada','recepcion_vehicular.km_salida','recepcion_vehicular.gas_entrada',
        'recepcion_vehicular.gas_salida','recepcion_vehicular.fecha','recepcion_vehicular.firma','recepcion_vehicular.carro',
        'recepcion_vehicular.fecha_compromiso','empresas.nombre','empresas.direccion','empresas.ciudad','empresas.estado','empresas.cp',
        'empresas.tel_negocio','empresas.tel_casa','empresas.tel_celular','empresas.email',
        'tipo_auto.nombre as tipo_auto','marcas.nombre as marca','modelos.nombre as modelo','colores.nombre as color','vehiculos.placas','vehiculos.anio','vehiculos.no_economico','vehiculos.vim','users.name','recepcion_vehicular.tecnico','recepcion_vehicular.fecha_entrega','recepcion_vehicular.folioNum')
        ->where('recepcion_vehicular.id','=',$id)
        ->orderBy('recepcion_vehicular.id','desc')->take(1)->get();

       }
       else 
       {
        $RecepcionVehicular = RecepcionVehicular::join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
        ->join('users','recepcion_vehicular.usuario_id','=','users.id')
        ->join('customers','recepcion_vehicular.customer_id','=','customers.id')
        ->join('vehiculos','recepcion_vehicular.vehiculo_id','=','vehiculos.id')
        ->join('tipo_auto','vehiculos.tipo_id','=','tipo_auto.id')
        ->join('marcas','vehiculos.marca_id','=','marcas.id')
        ->join('modelos','vehiculos.modelo_id','=','modelos.id')
        ->join('colores','vehiculos.color_id','=','colores.id')
        ->select('recepcion_vehicular.id','recepcion_vehicular.orden_seguimiento','recepcion_vehicular.folio','recepcion_vehicular.notas_adicionales',
        'recepcion_vehicular.indicaciones_del_cliente','recepcion_vehicular.km_entrada','recepcion_vehicular.km_salida','recepcion_vehicular.gas_entrada',
        'recepcion_vehicular.gas_salida','recepcion_vehicular.fecha','recepcion_vehicular.firma','recepcion_vehicular.carro',
        'recepcion_vehicular.fecha_compromiso','empresas.nombre','empresas.direccion','empresas.ciudad','empresas.estado','empresas.cp','customers.nombre as usuario',
        'empresas.tel_negocio','empresas.tel_casa','empresas.tel_celular','empresas.email',
        'tipo_auto.nombre as tipo_auto','marcas.nombre as marca','modelos.nombre as modelo','colores.nombre as color','vehiculos.placas','vehiculos.anio','vehiculos.no_economico','vehiculos.vim','users.name','recepcion_vehicular.tecnico','recepcion_vehicular.fecha_entrega','recepcion_vehicular.folioNum')
        ->where('recepcion_vehicular.id','=',$id)
        ->orderBy('recepcion_vehicular.id','desc')->take(1)->get();

       }

    
      

        $InterioresEquipo = InterioresEquipo::where('interiores_equipo.recepcion_vehicular_id','=',$id)
        ->orderBy('interiores_equipo.id','desc')->take(1)->get();

        $ExterioresEquipo = ExterioresEquipo::where('exteriores_equipo.recepcion_vehicular_id','=',$id)
        ->orderBy('exteriores_equipo.id','desc')->take(1)->get();

        $EquipoInventario = EquipoInventario::where('equipo_inventario.recepcion_vehicular_id','=',$id)
        ->orderBy('equipo_inventario.id','desc')->take(1)->get();

        $Seguro = Seguro::where('seguros.recepcion_vehicular_id','=',$id)
        ->orderBy('seguros.id','desc')->take(1)->get();

        $condicionesPintura = CondicionesPintura::where('condiciones_pintura.recepcion_vehicular_id','=',$id)
        ->orderBy('condiciones_pintura.id','desc')->take(1)->get();
       
     return \View::make('reportes.recepcion_vehicular', compact('RecepcionVehicular','InterioresEquipo','ExterioresEquipo',
     'EquipoInventario','Seguro','condicionesPintura'))->render();
   // $pdf  =  \App::make('dompdf.wrapper');
    //$pdf->loadHTML('<h1>Test</h1>');
   // $view =  \View::make('reportes.recepcion_vehicular', compact('cotizacion'))->render();
   // $pdf->loadHTML($view);
   // $pdf->stream();
    //return $pdf->stream('invoice');
  //  return $pdf->download('profile.pdf');

    }

    public function folioBuscar(Request $request){

       
        $Recepcion = RecepcionVehicular::where('recepcion_vehicular.folioNum','=',$request->id)
        ->select('recepcion_vehicular.id')->first();

     return $Recepcion->id;


    }

    public function indexarchivos(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        
        
            $tareas = RecepcionArchivos::select('id','recepcion_id','nombre','tipo')
            ->where('recepcion_id','=', $buscar)
            ->orderBy('id', 'desc')->paginate(30);

       
        
        return [
            'pagination' => [
                'total'        => $tareas->total(),
                'current_page' => $tareas->currentPage(),
                'per_page'     => $tareas->perPage(),
                'last_page'    => $tareas->lastPage(),
                'from'         => $tareas->firstItem(),
                'to'           => $tareas->lastItem(),
            ],
            'archivos' => $tareas
        ];
    }

    public function eliminar(Request $request){

 
        $sucursal = RecepcionArchivos::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
    public function subir(Request $request)
    {
        

        if($request->hasFile('files')){
            $files = $request->file('files');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extencion = $file->getClientOriginalExtension();
                $path = public_path().'/img/archivos/';
                $file->move($path, $filename);
                $user = new RecepcionArchivos();
                $user->recepcion_id = $request->id;
                $user->nombre = $filename;
                $user->tipo = $extencion;     
                $user->save();
                
            }
        }

        return count($files);
         

    }
    public function downloadFile($file){
        $pathtoFile = public_path().'/img/archivos/'.$file;
        return response()->download($pathtoFile);
      }

      public function delete(Request $request)
      {
         
          $sucursal = RecepcionVehicular::findOrFail($request->id);
         
          $so = CondicionesPintura::select('id')->where('recepcion_vehicular_id','=',$request->id)->get();
          $so1 = CondicionesPintura::findOrFail($so[0]['id']);
          $estado0= $so1->delete();
          $so2 = EquipoInventario::select('id')->where('recepcion_vehicular_id','=',$request->id)->get();
          $so3 = EquipoInventario::findOrFail($so2[0]['id']);
          $estado02= $so3->delete();
          $so4 = ExterioresEquipo::select('id')->where('recepcion_vehicular_id','=',$request->id)->get();
          $so5 = ExterioresEquipo::findOrFail($so4[0]['id']);
          $estado03= $so5->delete();
          $so6 = InterioresEquipo::select('id')->where('recepcion_vehicular_id','=',$request->id)->get();
          $so7 = InterioresEquipo::findOrFail($so6[0]['id']);
          $estado04= $so7->delete();
          $so8 = Seguro::select('id')->where('recepcion_vehicular_id','=',$request->id)->get();
          $so9 = Seguro::findOrFail($so8[0]['id']);
          $estado05= $so9->delete();
         
          $sucursal->delete();
  
        
         
          $estado = true;
          return collect(['estado' => $estado]);
      }
}
