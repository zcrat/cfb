<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Carbon;
use App\OrdenCompra;
use Illuminate\Http\Request;
use App\RecepcionVehicular;
use App\pConceptos2023;
use App\pConceptos;
use App\pCFEConceptos;
use App\Concepto;
use App\HojaConcepto;
use App\pCarrito2023;
use App\pCarrito;
use App\pCFECarrito;
use App\Vehiculo;
use App\Marca;
use App\Modelo;
use App\Articulo;
use Exception;
use Illuminate\Support\Facades\View;

class OrdenCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $OrdenCompra = new OrdenCompra;
        $HojaConcepto = new HojaConcepto;
        $Recepcion = new RecepcionVehicular;

        $OrdenCompras = $OrdenCompra->where('hoja_concepto_id','=',$request->id)->get();
        $data = [];


        foreach($OrdenCompras as $clave => $orden){

           
            $HojaConceptos = $HojaConcepto->where('id','=', $orden->hoja_concepto_id)->first();

            $Recepcions = $Recepcion->where('folioNUm','=', $HojaConceptos->odes)->first();

            $res = self::show($HojaConceptos->odes);
            $res = json_decode($res);

            $data[$clave] = [
                'id'               => $orden->id,
                'hoja_concepto_id' => $orden->hoja_concepto_id,
                'odes'             => $HojaConceptos->odes,
                'folio'            => $res->folio,
                'economico'            => $orden->economico,
                'vehiculo'         => $res->marcaModeloAnio,
                'fecha'            => $Recepcions->fecha,
                'fecha_creada'            => $orden->fecha_creada,
                'hora_creada'            => $orden->hora_creada,
                'para'            => $orden->para,
                'motor'            => $orden->motor,
                'tecnico'            => $orden->tecnico,
                'asignada_mensajero_hora'            => $orden->asignada_mensajero_hora,
                'entrega_mensajero_hora'            => $orden->entrega_mensajero_hora,
                'hora_firma'            => $orden->hora_firma,
            ];
        }
        return $data;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  \Exception  $exception
     */
    public function store(Request $request)
    {
      
        $ordenCompra = new OrdenCompra;
        $conceptos = new pCarrito2023;
        $Exception = new Exception;

        $ordenCompra->hoja_concepto_id =  $request['datos']['hoja_concepto_id'];
        
        $ordenCompra->fecha_creada = Carbon::parse( $request['datos']['fechaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->fecha_creada = new DateTime($ordenCompra->fecha_creada);
        $ordenCompra->fecha_creada = $ordenCompra->fecha_creada->format('Y/m/d');

        $ordenCompra->hora_creada = Carbon::parse( $request['datos']['horaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->hora_creada = new DateTime($ordenCompra->hora_creada);
        $ordenCompra->hora_creada = $ordenCompra->hora_creada->format('H:i');

        $ordenCompra->para =  $request['datos']['para'];
        $ordenCompra->motor =  $request['datos']['motor'];
        $ordenCompra->tecnico =  $request['datos']['tecnico'];
        $ordenCompra->economico =  $request['datos']['economico'];

        $ordenCompra->asignada_mensajero_hora = Carbon::parse( $request['datos']['asignadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->asignada_mensajero_hora = new DateTime($ordenCompra->asignada_mensajero_hora);
        $ordenCompra->asignada_mensajero_hora = $ordenCompra->asignada_mensajero_hora->format('H:i');

        $ordenCompra->entrega_mensajero_hora = Carbon::parse( $request['datos']['entregadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->entrega_mensajero_hora = new DateTime($ordenCompra->entrega_mensajero_hora);
        $ordenCompra->entrega_mensajero_hora = $ordenCompra->entrega_mensajero_hora->format('H:i');


        $ordenCompra->hora_firma = Carbon::parse( $request['datos']['horaRecibido'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->hora_firma = new DateTime($ordenCompra->hora_firma);
        $ordenCompra->hora_firma = $ordenCompra->hora_firma->format('H:i');
       
        $ordenCompra->save();
        
       
        foreach($request['conceptos'] as $key => $value) {     
            
           
            $prueba= Carbon::now('America/Lima');
            $fecha123 = Carbon::parse($value['fecha_aplicacion'])->format('Y-m-d H:m');
            $vehiculo = new pCarrito2023();
            $vehiculo->presupuesto_id = $value['presupuestoCFE_id'];
            $vehiculo->pConcepto_id = $value['pCFEConcepto_id'];
            $vehiculo->cantidad = $value['cantidad'];
            $vehiculo->precio = $value['precio_nuevo'];
            $vehiculo->precio_v = $value['precio'];
            $vehiculo->usuario_id = \Auth::user()->id;
            $vehiculo->remplazar = $value['remplazar'];
            $vehiculo->reparar = $value['reparar'];
            $vehiculo->fecha_aplicacion = $fecha123;
            $vehiculo->parte = $value['parte'];
            $vehiculo->mano_obra = $value['mano_obra'];
            $vehiculo->subcontratado = $value['subcontratado'];
            $vehiculo->otros = $value['otros'];
            $vehiculo->proveedor = $value['proveedor'];
            $vehiculo->clave = $value['clave'];
            $vehiculo->orden_compra_id = $ordenCompra->id;
            $vehiculo->save();

            $concepto2023 = new pConceptos2023;
            $conceptos2023 = $concepto2023->where('id', '=', $value['pCFEConcepto_id'])->first();
         

            $con = new Concepto();
            $con->orden_compra_id = $ordenCompra->id;
            $con->proveedor = $value['proveedor'];
            $con->clave = $value['clave'];
            $con->descripcion = $conceptos2023->descripcion;
            $con->cantidad = $value['cantidad'];
            $con->precio = $value['precio_nuevo'];
            $con->save();
        }
        return $request;
        

        
    }

    public function store4(Request $request)
    {
      
        $ordenCompra = new OrdenCompra;
        $conceptos = new pCarrito;
        $Exception = new Exception;

        $ordenCompra->hoja_concepto_id =  $request['datos']['hoja_concepto_id'];
        
        $ordenCompra->fecha_creada = Carbon::parse( $request['datos']['fechaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->fecha_creada = new DateTime($ordenCompra->fecha_creada);
        $ordenCompra->fecha_creada = $ordenCompra->fecha_creada->format('Y/m/d');

        $ordenCompra->hora_creada = Carbon::parse( $request['datos']['horaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->hora_creada = new DateTime($ordenCompra->hora_creada);
        $ordenCompra->hora_creada = $ordenCompra->hora_creada->format('H:i');

        $ordenCompra->para =  $request['datos']['para'];
        $ordenCompra->motor =  $request['datos']['motor'];
        $ordenCompra->tecnico =  $request['datos']['tecnico'];
        $ordenCompra->economico =  $request['datos']['economico'];

        $ordenCompra->asignada_mensajero_hora = Carbon::parse( $request['datos']['asignadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->asignada_mensajero_hora = new DateTime($ordenCompra->asignada_mensajero_hora);
        $ordenCompra->asignada_mensajero_hora = $ordenCompra->asignada_mensajero_hora->format('H:i');

        $ordenCompra->entrega_mensajero_hora = Carbon::parse( $request['datos']['entregadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->entrega_mensajero_hora = new DateTime($ordenCompra->entrega_mensajero_hora);
        $ordenCompra->entrega_mensajero_hora = $ordenCompra->entrega_mensajero_hora->format('H:i');


        $ordenCompra->hora_firma = Carbon::parse( $request['datos']['horaRecibido'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->hora_firma = new DateTime($ordenCompra->hora_firma);
        $ordenCompra->hora_firma = $ordenCompra->hora_firma->format('H:i');
       
        $ordenCompra->save();
        
       
        foreach($request['conceptos'] as $key => $value) {     
            
           
            $prueba= Carbon::now('America/Lima');
            $fecha123 = Carbon::parse($value['fecha_aplicacion'])->format('Y-m-d H:m');
            $vehiculo = new pCarrito();
            $vehiculo->presupuesto_id = $value['presupuestoCFE_id'];
            $vehiculo->pConcepto_id = $value['pCFEConcepto_id'];
            $vehiculo->cantidad = $value['cantidad'];
            $vehiculo->precio = $value['precio_nuevo'];
            $vehiculo->precio_v = $value['precio'];
            $vehiculo->usuario_id = \Auth::user()->id;
            $vehiculo->remplazar = $value['remplazar'];
            $vehiculo->reparar = $value['reparar'];
            $vehiculo->fecha_aplicacion = $fecha123;
            $vehiculo->parte = $value['parte'];
            $vehiculo->mano_obra = $value['mano_obra'];
            $vehiculo->subcontratado = $value['subcontratado'];
            $vehiculo->otros = $value['otros'];
            $vehiculo->proveedor = $value['proveedor'];
            $vehiculo->clave = $value['clave'];
            $vehiculo->orden_compra_id = $ordenCompra->id;
            $vehiculo->save();

            $concepto2023 = new pConceptos;
            $conceptos2023 = $concepto2023->where('id', '=', $value['pCFEConcepto_id'])->first();
         

            $con = new Concepto();
            $con->orden_compra_id = $ordenCompra->id;
            $con->proveedor = $value['proveedor'];
            $con->clave = $value['clave'];
            $con->descripcion = $conceptos2023->descripcion;
            $con->cantidad = $value['cantidad'];
            $con->precio = $value['precio_nuevo'];
            $con->save();
        }
        return $request;
        

        
    }


    public function store3(Request $request)
    {
      
        $ordenCompra = new OrdenCompra;
        $conceptos = new pCFECarrito;
        $Exception = new Exception;

        $ordenCompra->hoja_concepto_id =  $request['datos']['hoja_concepto_id'];
        
        $ordenCompra->fecha_creada = Carbon::parse( $request['datos']['fechaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->fecha_creada = new DateTime($ordenCompra->fecha_creada);
        $ordenCompra->fecha_creada = $ordenCompra->fecha_creada->format('Y/m/d');

        $ordenCompra->hora_creada = Carbon::parse( $request['datos']['horaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->hora_creada = new DateTime($ordenCompra->hora_creada);
        $ordenCompra->hora_creada = $ordenCompra->hora_creada->format('H:i');

        $ordenCompra->para =  $request['datos']['para'];
        $ordenCompra->motor =  $request['datos']['motor'];
        $ordenCompra->tecnico =  $request['datos']['tecnico'];
        $ordenCompra->economico =  $request['datos']['economico'];

        $ordenCompra->asignada_mensajero_hora = Carbon::parse( $request['datos']['asignadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->asignada_mensajero_hora = new DateTime($ordenCompra->asignada_mensajero_hora);
        $ordenCompra->asignada_mensajero_hora = $ordenCompra->asignada_mensajero_hora->format('H:i');

        $ordenCompra->entrega_mensajero_hora = Carbon::parse( $request['datos']['entregadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->entrega_mensajero_hora = new DateTime($ordenCompra->entrega_mensajero_hora);
        $ordenCompra->entrega_mensajero_hora = $ordenCompra->entrega_mensajero_hora->format('H:i');


        $ordenCompra->hora_firma = Carbon::parse( $request['datos']['horaRecibido'])->timezone('America/Mexico_City')->toDateTimeString();
        $ordenCompra->hora_firma = new DateTime($ordenCompra->hora_firma);
        $ordenCompra->hora_firma = $ordenCompra->hora_firma->format('H:i');
       
        $ordenCompra->save();
        
       
        foreach($request['conceptos'] as $key => $value) {     
            
           
            $prueba= Carbon::now('America/Lima');
            $fecha123 = Carbon::parse($value['fecha_aplicacion'])->format('Y-m-d H:m');
            $vehiculo = new pCFECarrito();
            $vehiculo->presupuestoCFE_id = $value['presupuestoCFE_id'];
            $vehiculo->pCFEConcepto_id = $value['pCFEConcepto_id'];
            $vehiculo->cantidad = $value['cantidad'];
            $vehiculo->precio = $value['precio_nuevo'];
            $vehiculo->precio_v = $value['precio'];
            $vehiculo->usuario_id = \Auth::user()->id;
            $vehiculo->remplazar = $value['remplazar'];
            $vehiculo->reparar = $value['reparar'];
            $vehiculo->fecha_aplicacion = $fecha123;
            $vehiculo->parte = $value['parte'];
            $vehiculo->mano_obra = $value['mano_obra'];
            $vehiculo->subcontratado = $value['subcontratado'];
            $vehiculo->otros = $value['otros'];
            $vehiculo->proveedor = $value['proveedor'];
            $vehiculo->clave = $value['clave'];
            $vehiculo->orden_compra_id = $ordenCompra->id;
            $vehiculo->save();

            $concepto2023 = new pCFEConceptos;
            $conceptos2023 = $concepto2023->where('id', '=', $value['pCFEConcepto_id'])->first();
         

            $con = new Concepto();
            $con->orden_compra_id = $ordenCompra->id;
            $con->proveedor = $value['proveedor'];
            $con->clave = $value['clave'];
            $con->descripcion = $conceptos2023->descripcion;
            $con->cantidad = $value['cantidad'];
            $con->precio = $value['precio_nuevo'];
            $con->save();
        }
        return $request;
        

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function show($getDatum)
    {
        $ordenCompra = new OrdenCompra;
        $recepcionVehicular = new RecepcionVehicular;
        $hojaConceptos = new HojaConcepto;
        $conceptos = new pCarrito2023;
        $vehiculo = new Vehiculo;
        $marca = new Marca;
        $modelo = new Modelo;
        $articulo = new Articulo;

        $data = array();
        $recepcion = $recepcionVehicular->where('folioNum', '=' ,$getDatum)->first();
        

        if($recepcion){
            $r = $vehiculo->where('id', '=', $recepcion->vehiculo_id)->first();
            $res = $marca->where('id', '=', $r->marca_id)->first();
            $re = $modelo->where('id', '=', $r->modelo_id)->first();
            $data["marcaModeloAnio"] = $res->nombre."/".$re->nombre."/".$r->anio;
            $data['folio'] = $recepcion->folio;
            $hojaConceptos = $hojaConceptos->where('id_recepcion', '=', $recepcion->id)->first();
            $data['idHojaConcepto'] = $hojaConceptos->id;
            $conceptos = $conceptos->where('presupuesto_id','=',$hojaConceptos->presupuesto_id)->get();
            $data['numConcepto'] = $conceptos->where('id_hoja_conceptos','=',$hojaConceptos->id)->max('num_concepto');


            /*$data['conceptos'] = $conceptos;
            foreach($conceptos as $key => $valor){
                $r = $articulo->where('id', '=', $valor->id_articulo)->first();
                //$r = $valor->id_articulos;
                $data['conceptos'][$key]['clave'] = $r->codigo_sat;
                $data['conceptos'][$key]['descripcion'] = $r->descripcion;
            }*/
            
            return json_encode($data);
        }else{
            return 'no value';
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function edit($id, OrdenCompra $ordenCompra)
    {
        $conceptos = new Concepto;

        $ordenCompra = $ordenCompra->where('id','=',$id)->first();
        $conceptos = $conceptos->where('id_orden_compra', '=', $ordenCompra->id)->get();
        $numConcepto = $conceptos->where('id_hoja_conceptos','=',$conceptos['0']->id_hoja_conceptos)->max('num_concepto');

        $num = 0;
        foreach($conceptos as $clave=>$concepto){
            $num += 1;
            $articulos = new Articulo;
            $articulo = $articulos->where('id','=', $concepto['id_articulo'])->first();

            $dataConceptos[$clave] = [
                'id'              => $concepto['id'],
                'idLocal'         => $num,
                'id_orden_compra' => $concepto['id_orden_compra'],
                'numConcepto'     => $concepto['num_concepto'],
                'id_articulo'     => $concepto['id_articulo'],
                'clave'           => $articulo->codigo_sat,
                'cantidad'        => $concepto['cantidad'],
                'descripcion'     => $articulo->descripcion,
                'precio'          => $concepto['partes'],
                'monto'           => $concepto['subtotal_costos']
            ];
        }

        $show = self::show($ordenCompra->ordenRegistro);
        $show = json_decode($show);
        $data = [
            'ordenCompra' => [
                'id'                     => $ordenCompra->id,
                'fechaCreacion'          => $ordenCompra->fecha_creada,
                'horaCreacion'           => $ordenCompra->hora_creada,
                'folio'                  => $ordenCompra->folio,
                'para'                   => $ordenCompra->para,
                'asignadaMensajeroHora'  => $ordenCompra->asignada_mensajero_hora,
                'entregadaMensajeroHora' => $ordenCompra->entrega_mensajero_hora,
                'horaRecibido'           => $ordenCompra->hora_firma,
                'firmaRecibido'          => $ordenCompra->firma_recibido,
                'firmaAutoriza'          => $ordenCompra->autorizado,
                'ordenSeguimiento'       => $ordenCompra->ordenRegistro,
                'marcaModeloAnio'        => $show->marcaModeloAnio,
                'numConcepto'            => $numConcepto
            ],
            'conceptos'  => $dataConceptos
            
        ];

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $ordenCompra   = new OrdenCompra;

        try {
           
            $ordenCompra = $ordenCompra->where('id','=', $request['ordenCompra']['id'])->first();

            $ordenCompra->id            = $request['ordenCompra']['id'];
            $ordenCompra->para         = $request['ordenCompra']['para'];
            $ordenCompra->motor         = $request['ordenCompra']['motor'];
            $ordenCompra->tecnico         = $request['ordenCompra']['tecnico'];
            $ordenCompra->economico =  $request['ordenCompra']['economico'];

            $ordenCompra->fecha_creada  = Carbon::parse($request['ordenCompra']['fechaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
            $ordenCompra->fecha_creada  = new DateTime($ordenCompra->fecha_creada);
            $ordenCompra->fecha_creada  = $ordenCompra->fecha_creada->format('Y/m/d');

            $ordenCompra->hora_creada   = Carbon::parse($request['ordenCompra']['horaCreacion'])->timezone('America/Mexico_City')->toDateTimeString();
            $ordenCompra->hora_creada   = new DateTime($ordenCompra->hora_creada);
            $ordenCompra->hora_creada   = $ordenCompra->hora_creada->format('H:i');

            $ordenCompra->asignada_mensajero_hora = Carbon::parse($request['ordenCompra']['asignadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
            $ordenCompra->asignada_mensajero_hora = new DateTime($ordenCompra->asignada_mensajero_hora);
            $ordenCompra->asignada_mensajero_hora = $ordenCompra->asignada_mensajero_hora->format('H:i');

            $ordenCompra->entrega_mensajero_hora = Carbon::parse($request['ordenCompra']['entregadaMensajeroHora'])->timezone('America/Mexico_City')->toDateTimeString();
            $ordenCompra->entrega_mensajero_hora = new DateTime($ordenCompra->entrega_mensajero_hora);
            $ordenCompra->entrega_mensajero_hora = $ordenCompra->entrega_mensajero_hora->format('H:i');

            $ordenCompra->hora_firma             = Carbon::parse($request['ordenCompra']['horaRecibido'])->timezone('America/Mexico_City')->toDateTimeString();
            $ordenCompra->hora_firma             = new DateTime($ordenCompra->hora_firma);
            $ordenCompra->hora_firma             = $ordenCompra->hora_firma->format('H:i');

            $ordenCompra->save();

           
            return $request['ordenCompra'];
        } catch (Exception $e) {
            return $e;
        }
        
        return $request['ordenCompra'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenCompra $ordenCompra)
    {
        //
    }

    public function reporte($id)
    {
        $OrdenCompra = new OrdenCompra;
        $HojaConcepto = new HojaConcepto;
        $Concepto     = new pCarrito2023;
      
        $OrdenCompras = $OrdenCompra->where('id', '=', $id)->first();
        $hojaConceptos = $HojaConcepto->where('id', '=', $OrdenCompras->hoja_concepto_id)->first();

        $Conceptos = $Concepto->where('orden_compra_id','=',$id)->get();

    
        $data = self::getOrdenSeguimiento($hojaConceptos->odes);

        
    

        return View::make('reportes.ordenCompra') -> with(['reporte' => $data, 'hojaConceptos' => $hojaConceptos, 'conceptos' => $Conceptos]);

        //return View::make('reportes.ordenCompra')->with(['data'=>$data, 'autorizado'=>$OrdenCompra->autorizado, 'firmaRecibido'=>$OrdenCompra->firma_recibido]);
    }

    public function getPartes(Request $request)
    {

        $Articulo = new Concepto;

        $servicio = $Articulo->where('orden_compra_id', '=', $request->id)->get();
        return $servicio;
    }
}
