<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\RecepcionVehicular;
use App\Empresa;
use App\Cliente;
use App\Vehiculo;
use App\Marca;
use App\Modelo;
use App\Color;
use App\Persona;
use App\Articulo;
use App\HojaConcepto;
use App\Concepto;
use App\Customer;
use DateTime;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;


use App\pCarrito2023;
use App\pCarrito;
use App\pCFECarrito;

use App\pCategorias2023;
use App\pTipos2023;

use App\CodigoSat;
use App\OrdenCompra;

use App\pCFECategorias;
use App\pCFETipos;

use App\pCategorias;
use App\pTipos;

class HojaConceptoController extends Controller
{

    public function index(Request $request)
    {
    
    
        $HojaConceptone = new HojaConcepto;
        $RecepcionVehicular = new RecepcionVehicular;

        if($request->modulo == 5){
            $categorias = pCategorias2023::get();
            $tipos = pTipos2023::get();
        }

        if($request->modulo == 4){
            $categorias = pCategorias::get();
            $tipos = pTipos::get();
        }

        if($request->modulo == 3){
            $categorias = pCFECategorias::where('CFE_id','=','3')->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id','=','3')->orderBy('tipo', 'asc')->get();
        }

        if($request->modulo == 2){
            $categorias = pCFECategorias::where('CFE_id','=','2')->get();
            $tipos = pCFETipos::where('CFE_id','=','2')->get();
        }
       



        $productos = CodigoSat::get();
        $HojaConceptos = $HojaConceptone->where('modulo','=',$request->modulo)->orderBy('id', 'desc')->get();
        

        foreach($HojaConceptos as $clave => $HojaConcepto){
            
            $RecepcionVehicular = $RecepcionVehicular->where('id','=',$HojaConcepto->id_recepcion)->first();
            
                $res = self::getOrdenSeguimiento($HojaConcepto->odes);
            
                $data[$clave] = array(
                    'id'                  => $HojaConcepto->id,
                    'presupuesto_id'      => $HojaConcepto->presupuesto_id,
                    'tecnico'             => $HojaConcepto->id_tecnico,
                    'status'              => $HojaConcepto->status,
                    'orden_seguimiento'   => $RecepcionVehicular->folioNum,
                    'folio'               => $RecepcionVehicular->folio,
                    'empresaNombre'       => $res['nombre'],
                    'vehiculoPlacas'      => $res['placas'],
                    'vehiculoMarcaModelo' => $res['marca'].$res['modelo'],
                    'fecha'               => $res['fecha'],
                    'fecha_compromiso'    => $RecepcionVehicular->fecha
                );
            
            
        }

        return [
            'hojas' => $data,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'productos' => $productos,
        ];


    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function conceptos($getDatum)
    {
        
        $conceptos = pCarrito2023::join('pConceptos2023','pCarrito2023.pConcepto_id','=','pConceptos2023.id')
        ->select('pCarrito2023.id','pConceptos2023.descripcion','pCarrito2023.cantidad','pCarrito2023.precio','pCarrito2023.precio_v','pCarrito2023.remplazar','pCarrito2023.reparar','pCarrito2023.fecha_aplicacion','pCarrito2023.parte','pCarrito2023.mano_obra','pCarrito2023.subcontratado','pCarrito2023.otros','pCarrito2023.proveedor','pCarrito2023.clave','pCarrito2023.status')
        ->where('pCarrito2023.presupuesto_id','=',$getDatum)->get();
        
        $concep = array();
        foreach($conceptos as $clave => $valor){
           
            $concep[$clave]['id']                 = $valor['id'];
            $concep[$clave]['numConcepto']        = $valor['cantidad'];
            $concep[$clave]['remplazar']          = $valor['remplazar'];
            $concep[$clave]['reparar']            = $valor['reparar'];
            $concep[$clave]['fechaAplicacion']    = $valor['fecha_aplicacion'];
            $concep[$clave]['descripcion']        = $valor['descripcion'];
            $concep[$clave]['costoParte']         = $valor['parte'];
            $concep[$clave]['costoManoObra']      = $valor['mano_obra'];
            $concep[$clave]['costoSubcontratado'] = $valor['subcontratado'];
            $concep[$clave]['costoOtros']         = $valor['otros'];
            $concep[$clave]['subTotalCostos']     = $valor['precio'];
            $concep[$clave]['precio_publico']     = $valor['precio_v'];
            $concep[$clave]['proveedor']     = $valor['proveedor'];
            $concep[$clave]['clave']     = $valor['clave'];
            $concep[$clave]['status']     = $valor['status'];
        }

        return [
            'conceptos' => $concep,
        ];

    }

    public function conceptos4($getDatum)
    {
        
        $conceptos = pCarrito::join('pConceptos','pCarrito.pConcepto_id','=','pConceptos.id')
        ->select('pCarrito.id','pConceptos.descripcion','pCarrito.cantidad','pCarrito.precio','pCarrito.precio_v','pCarrito.remplazar','pCarrito.reparar','pCarrito.fecha_aplicacion','pCarrito.parte','pCarrito.mano_obra','pCarrito.subcontratado','pCarrito.otros','pCarrito.proveedor','pCarrito.clave','pCarrito.status')
        ->where('pCarrito.presupuesto_id','=',$getDatum)->get();
        
        $concep = array();
        foreach($conceptos as $clave => $valor){
           
            $concep[$clave]['id']                 = $valor['id'];
            $concep[$clave]['numConcepto']        = $valor['cantidad'];
            $concep[$clave]['remplazar']          = $valor['remplazar'];
            $concep[$clave]['reparar']            = $valor['reparar'];
            $concep[$clave]['fechaAplicacion']    = $valor['fecha_aplicacion'];
            $concep[$clave]['descripcion']        = $valor['descripcion'];
            $concep[$clave]['costoParte']         = $valor['parte'];
            $concep[$clave]['costoManoObra']      = $valor['mano_obra'];
            $concep[$clave]['costoSubcontratado'] = $valor['subcontratado'];
            $concep[$clave]['costoOtros']         = $valor['otros'];
            $concep[$clave]['subTotalCostos']     = $valor['precio'];
            $concep[$clave]['precio_publico']     = $valor['precio_v'];
            $concep[$clave]['proveedor']     = $valor['proveedor'];
            $concep[$clave]['clave']     = $valor['clave'];
            $concep[$clave]['status']     = $valor['status'];
        }

        return [
            'conceptos' => $concep,
        ];

    }

    public function conceptos3($getDatum)
    {
        
        $conceptos = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
        ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio','pCFECarrito.precio_v','pCFECarrito.remplazar','pCFECarrito.reparar','pCFECarrito.fecha_aplicacion','pCFECarrito.parte','pCFECarrito.mano_obra','pCFECarrito.subcontratado','pCFECarrito.otros','pCFECarrito.proveedor','pCFECarrito.clave','pCFECarrito.status')
        ->where('pCFECarrito.presupuestoCFE_id','=',$getDatum)->get();
        
        $concep = array();
        foreach($conceptos as $clave => $valor){
           
            $concep[$clave]['id']                 = $valor['id'];
            $concep[$clave]['numConcepto']        = $valor['cantidad'];
            $concep[$clave]['remplazar']          = $valor['remplazar'];
            $concep[$clave]['reparar']            = $valor['reparar'];
            $concep[$clave]['fechaAplicacion']    = $valor['fecha_aplicacion'];
            $concep[$clave]['descripcion']        = $valor['descripcion'];
            $concep[$clave]['costoParte']         = $valor['parte'];
            $concep[$clave]['costoManoObra']      = $valor['mano_obra'];
            $concep[$clave]['costoSubcontratado'] = $valor['subcontratado'];
            $concep[$clave]['costoOtros']         = $valor['otros'];
            $concep[$clave]['subTotalCostos']     = $valor['precio'];
            $concep[$clave]['precio_publico']     = $valor['precio_v'];
            $concep[$clave]['proveedor']     = $valor['proveedor'];
            $concep[$clave]['clave']     = $valor['clave'];
            $concep[$clave]['status']     = $valor['status'];
        }

        return [
            'conceptos' => $concep,
        ];

    }
    public function getOrdenSeguimiento($getDatum)
    {
        $RecepcionVehicular = new RecepcionVehicular;
        $empresa = new Empresa;
        $customer = new Customer;
        $cliente = new Cliente;
        $Vehiculo = new Vehiculo;
        $marca = new Marca;
        $Modelo = new Modelo;
        $Color = new Color;

        $data = array(
            'idRecepcion' => "",
            'odes' => $getDatum,  
            "nombre"=> "",
            "economico"=> "",            
            "anio"=> "",
            "marca"=> "",            
            "modelo"=> "",   
            "color" => "",
            "placas"=> "",
            "km"=> "",
            "vin"=> "",
            "fecha"=> "",          
            "folio"=> ""      
        );

        
        
        $res = $RecepcionVehicular->where('folioNum','=',$getDatum)->first();

        
        $data['km'] = $res->km_entrada;
        $data['idRecepcion'] = $res->id;
        $data['folio'] = $res->folio;
        $data['usuario'] = $res->usuario;
        $data['administrador'] = $res->administrador;
        $data['jefedeprocesos'] = $res->jefedeprocesos;
        $data['telefonojefe'] = $res->telefonojefe;
        $data['trabajador'] = $res->trabajador;

        $rcus = $customer->where('id','=',$res->customer_id)->first();
        $data['usuario'] = $rcus->nombre;


       

        $res->fecha = new DateTime($res->fecha);
        $data['fecha'] = $res->fecha->format('Y-m-d');

        //$data['fecha'] = $res->fecha;

        if($res->empresa_id){
            $r = $empresa->where('id','=', $res->empresa_id)->first();
            $data['nombre'] = $r->nombre;
            $data['ciudad'] = $r->ciudad;

            
            
        }else{
            $r = $cliente->where('id', '=', $res->customer_id)->first();
            $data['nombre'] = $r->nombre;
        }

        $r = $Vehiculo->where('id', '=', $res->vehiculo_id)->first();
        $data['placas'] = $r->placas;
        $data['vin'] = $r->vim;
        $data['economico'] = $r->no_economico;
        $data['anio'] = $r->anio;
        $data['color'] = $r->color_id;
        $modelo = $r->modelo_id;

        $r = $marca->where('id','=',$r->marca_id)->first();
        $marca = $r->nombre;

        $r = $Color->where('id', '=',$data['color'])->first();
        $data['color'] = $r->nombre;

        $r = $Modelo->where('id','=',$modelo)->first();
        $modelo = $r->nombre;

        $data['marca'] = $marca;
        $data['modelo'] = $modelo;


        return $data;

    }

    public function getTecnicos()
    {   
        $Persona = new Persona;

        $tecnicos = $Persona
                        ->join('roles', 'personas.rol_id', 'roles.id')
                        ->select('personas.id','personas.nombre')
                        ->get();
        
        return $tecnicos;
    }

    public function getArticulo()
    {
        $Articulo = new Articulo;

        $servicio = $Articulo->where('idcategoria',1)->get();
        return $servicio;
    }


    /**
     * the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspeccionTecnicaVehiculo  $inspeccionTecnicaVehiculo
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request  $request)
    {

        $HojaConcepto = new HojaConcepto;

        $hojaConcepto = $HojaConcepto->where('id','=',$id)->first();

        $hojaConcepto->id_recepcion                 = $request['dataHojaConceptos']['idRecepcion'];
        $hojaConcepto->id_tecnico                   = $request['dataHojaConceptos']['tecnico'];
        $hojaConcepto->odes                         = $request['dataHojaConceptos']['odes'];
        $hojaConcepto->r_r                          = $request['dataHojaConceptos']['rr'];
        $hojaConcepto->fecha_hoja_concepto          = Carbon::parse($request['dataHojaConceptos']['hojaConceptoFecha'])->timezone('America/Mexico_City')->toDateTimeString();
        $hojaConcepto->subtotal_partes              = $request['dataHojaConceptos']['subTotalPartes'];
        $hojaConcepto->subtotal_mano_obra           = $request['dataHojaConceptos']['subTotalManoObra'];
        $hojaConcepto->subtotal_subcontratado       = $request['dataHojaConceptos']['subTotalSubcontratado'];
        $hojaConcepto->subtotal_otros               = $request['dataHojaConceptos']['subTotalOtros'];
        $hojaConcepto->subtotal_subtotal_costos     = $request['dataHojaConceptos']['subTotalSubtotalCostos'];
        $hojaConcepto->iva_subtotal_partes          = $request['dataHojaConceptos']['ivaPartes'];
        $hojaConcepto->iva_subtotal_mano_obra       = $request['dataHojaConceptos']['ivaManoObra'];
        $hojaConcepto->iva_subtotal_subcontratado   = $request['dataHojaConceptos']['ivaSubcontratado'];
        $hojaConcepto->iva_subtotal_otros           = $request['dataHojaConceptos']['ivaOtros'];
        $hojaConcepto->iva_subtotal_subtotal_costos = $request['dataHojaConceptos']['ivaSubtotalCostos'];
        $hojaConcepto->total_partes                 = $request['dataHojaConceptos']['totalPartes'];
        $hojaConcepto->total_mano_obra              = $request['dataHojaConceptos']['totalManoObra'];
        $hojaConcepto->total_subcontratado          = $request['dataHojaConceptos']['totalSubcontratado'];
        $hojaConcepto->total_otros                  = $request['dataHojaConceptos']['totalOtros'];
        $hojaConcepto->total_subtotal_costos        = $request['dataHojaConceptos']['totalSubtotalCostos'];
        $hojaConcepto->autorizacion                 = $request['dataHojaConceptos']['firma'];
        $hojaConcepto->status                       = $request['dataHojaConceptos']['status'];

        
        $res = $hojaConcepto->save();

        if ($res) {
            return ['estado'=>true];
        }
        return ['estado'=>false];
    }

    public function updateConceptos(Request $request)
    {


        $vehiculo = new pCarrito2023;
        $vehiculo = $vehiculo->where('id','=',$request->id)->first();
        $vehiculo->cantidad = $request->num_concepto;
        $vehiculo->precio = $request->subtotal_costos;
        $vehiculo->precio_v = $request->precio_publico;
        $vehiculo->remplazar = $request->remplazar;
        $vehiculo->reparar = $request->reparar;
        $vehiculo->fecha_aplicacion =  Carbon::parse($request->fecha_aplicacion)->timezone('America/Mexico_City')->toDateTimeString();
        $vehiculo->parte = $request->partes;
        $vehiculo->mano_obra = $request->mano_obra;
        $vehiculo->subcontratado = $request->subcontratado;
        $vehiculo->otros = $request->otros;
        $vehiculo->proveedor = $request->proveedor;
        $vehiculo->clave = $request->clave;
        $vehiculo->status = $request->status;
        $vehiculo->save();
       
        return [
            'id'=> $vehiculo->id
        ];
    }

    public function updateConceptos4(Request $request)
    {


        $vehiculo = new pCarrito;
        $vehiculo = $vehiculo->where('id','=',$request->id)->first();
        $vehiculo->cantidad = $request->num_concepto;
        $vehiculo->precio = $request->subtotal_costos;
        $vehiculo->precio_v = $request->precio_publico;
        $vehiculo->remplazar = $request->remplazar;
        $vehiculo->reparar = $request->reparar;
        $vehiculo->fecha_aplicacion =  Carbon::parse($request->fecha_aplicacion)->timezone('America/Mexico_City')->toDateTimeString();
        $vehiculo->parte = $request->partes;
        $vehiculo->mano_obra = $request->mano_obra;
        $vehiculo->subcontratado = $request->subcontratado;
        $vehiculo->otros = $request->otros;
        $vehiculo->proveedor = $request->proveedor;
        $vehiculo->clave = $request->clave;
        $vehiculo->status = $request->status;
        $vehiculo->save();
       
        return [
            'id'=> $vehiculo->id
        ];
    }

    public function updateConceptos3(Request $request)
    {


        $vehiculo = new pCFECarrito;
        $vehiculo = $vehiculo->where('id','=',$request->id)->first();
        $vehiculo->cantidad = $request->num_concepto;
        $vehiculo->precio = $request->subtotal_costos;
        $vehiculo->precio_v = $request->precio_publico;
        $vehiculo->remplazar = $request->remplazar;
        $vehiculo->reparar = $request->reparar;
        $vehiculo->fecha_aplicacion =  Carbon::parse($request->fecha_aplicacion)->timezone('America/Mexico_City')->toDateTimeString();
        $vehiculo->parte = $request->partes;
        $vehiculo->mano_obra = $request->mano_obra;
        $vehiculo->subcontratado = $request->subcontratado;
        $vehiculo->otros = $request->otros;
        $vehiculo->proveedor = $request->proveedor;
        $vehiculo->clave = $request->clave;
        $vehiculo->status = $request->status;
        $vehiculo->save();
       
        return [
            'id'=> $vehiculo->id
        ];
    }

    public function edit($odes)
    {
       
        $HojaConcepto = new HojaConcepto;
        $concepto = new Concepto;
        $Articulo = new Articulo;

        $hojaConcepto = $HojaConcepto->where('id','=',$odes)->first();
        
        $hojaConcepto->fecha_hoja_concepto = new DateTime($hojaConcepto->fecha_hoja_concepto);
        $hojaConcepto->fecha_hoja_concepto = $hojaConcepto->fecha_hoja_concepto->format('Y-m-d\Th:i:s\Z');

       
     

        $ordenSeguimiento = self::getOrdenSeguimiento($hojaConcepto->odes);
        

        
        $data = array(
            'hojaConcepto' => array(
                'id'                     => $hojaConcepto->id,
                'odes'                   => $hojaConcepto->odes,
                'presupuesto_id'         => $hojaConcepto->presupuesto_id,
                'status'                 => $hojaConcepto->status,
                'idRecepcion'            => $hojaConcepto->id_recepcion,
                'tecnico'                => $hojaConcepto->id_tecnico,
                'rr'                     => $hojaConcepto->r_r,    
                'hojaConceptoFecha'      => $hojaConcepto->fecha_hoja_concepto,
                'subTotalPartes'         => $hojaConcepto->subtotal_partes,
                'subTotalManoObra'       => $hojaConcepto->subtotal_mano_obra,
                'subTotalSubcontratado'  => $hojaConcepto->subtotal_subcontratado,
                'subTotalOtros'          => $hojaConcepto->subtotal_otros,
                'subTotalSubtotalCostos' => $hojaConcepto->subtotal_subtotal_costos,
                'ivaPartes'              => $hojaConcepto->iva_subtotal_partes,
                'ivaManoObra'            => $hojaConcepto->iva_subtotal_mano_obra,
                'ivaSubcontratado'       => $hojaConcepto->iva_subtotal_subcontratado,
                'ivaOtros'               => $hojaConcepto->iva_subtotal_otros,
                'ivaSubtotalCostos'      => $hojaConcepto->iva_subtotal_subtotal_costos,
                'totalPartes'            => $hojaConcepto->total_partes,
                'totalManoObra'          => $hojaConcepto->total_mano_obra,
                'totalSubcontratado'     => $hojaConcepto->total_subcontratado,
                'totalOtros'             => $hojaConcepto->total_otros,
                'totalSubtotalCostos'    => $hojaConcepto->total_subtotal_costos,
                'firma'                  => $hojaConcepto->autorizacion
            ),

            'ordenSeguimiento' => $ordenSeguimiento

        );

        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $Response
     * @param  \Exception  $Exception
     */
    public function storeConcepto(Request $request){
      

        $Conceptos = new Concepto;
        $Conceptos->id_hoja_conceptos = $request->dataConceptos['id'];
        $Conceptos->num_concepto      = $request->dataConceptos['numConcepto'];            
        $Conceptos->descripcion       = $request->dataConceptos['descripcion'];            
        $Conceptos->remplazar         = $request->dataConceptos['remplazar'];
        $Conceptos->reparar           = $request->dataConceptos['reparar'];
        $Conceptos->cantidad            = '1';
        $Conceptos->fecha_aplicacion  = Carbon::parse($request->dataConceptos['fechaAplicacion'])->timezone('America/Mexico_City')->toDateTimeString();
        $Conceptos->partes            = $request->dataConceptos['costoParte'];
        $Conceptos->mano_obra         = (float) number_format($request->dataConceptos['costoManoObra']);
        $Conceptos->subcontratado     = (float) number_format($request->dataConceptos['costoSubcontratado']);
        $Conceptos->otros             = (float) number_format($request->dataConceptos['costoOtros']);
        $Conceptos->subtotal_costos   = $request->dataConceptos['subTotalCostos'];
        $Conceptos->precio_publico   = $request->dataConceptos['precio_publico'];
        $Conceptos->codigo_sat   = $request->dataConceptos['codigo_sat'];
        $Conceptos->codigo_unidad   = $request->dataConceptos['codigo_unidad'];
        $Conceptos->unidad_text   = $request->dataConceptos['unidad_text'];

        $res = $Conceptos->save();

        if($res){
            return ['estado' => true];
        }
        return ['estado' => false];
    }
    public function store(Request $request)
    {   
        $HojaConcepto = new HojaConcepto;
        $Exception = new Exception;

        $HojaConcepto->id_recepcion                 = $request['dataHojaConceptos']['idRecepcion'];
        $HojaConcepto->id_tecnico                   = $request['dataHojaConceptos']['idTecnico'];
        $HojaConcepto->odes                         = $request['dataHojaConceptos']['odes'];
        $HojaConcepto->r_r                          = $request['dataHojaConceptos']['rr'];
        $HojaConcepto->fecha_hoja_concepto          = Carbon::parse($request['dataHojaConceptos']['hojaConceptoFecha'])->timezone('America/Mexico_City')->toDateTimeString();
        $HojaConcepto->subtotal_partes              = $request['dataHojaConceptos']['subTotalPartes'];
        $HojaConcepto->subtotal_mano_obra           = $request['dataHojaConceptos']['subTotalManoObra'];
        $HojaConcepto->subtotal_subcontratado       = $request['dataHojaConceptos']['subTotalSubcontratado'];
        $HojaConcepto->subtotal_otros               = $request['dataHojaConceptos']['subTotalOtros'];
        $HojaConcepto->subtotal_subtotal_costos     = $request['dataHojaConceptos']['subTotalSubtotalCostos'];
        $HojaConcepto->iva_subtotal_partes          = $request['dataHojaConceptos']['ivaPartes'];
        $HojaConcepto->iva_subtotal_mano_obra       = $request['dataHojaConceptos']['ivaManoObra'];
        $HojaConcepto->iva_subtotal_subcontratado   = $request['dataHojaConceptos']['ivaSubcontratado'];
        $HojaConcepto->iva_subtotal_otros           = $request['dataHojaConceptos']['ivaOtros'];
        $HojaConcepto->iva_subtotal_subtotal_costos = $request['dataHojaConceptos']['ivaSubtotalCostos'];
        $HojaConcepto->total_partes                 = $request['dataHojaConceptos']['totalPartes'];
        $HojaConcepto->total_mano_obra              = $request['dataHojaConceptos']['totalManoObra'];
        $HojaConcepto->total_subcontratado          = $request['dataHojaConceptos']['totalSubcontratado'];
        $HojaConcepto->total_otros                  = $request['dataHojaConceptos']['totalOtros'];
        $HojaConcepto->total_subtotal_costos        = $request['dataHojaConceptos']['totalSubtotalCostos'];
        $HojaConcepto->autorizacion                 = $request['dataHojaConceptos']['firma'];

        $res = $HojaConcepto->save();

        foreach($request->dataConceptos as $clave => $valor){
            $Conceptos = new Concepto;
            $Conceptos->id_hoja_conceptos = $HojaConcepto->id;
            $Conceptos->num_concepto      = $valor['numConcepto'];            
            $Conceptos->descripcion       = $valor['descripcion'];            
            $Conceptos->remplazar         = $valor['remplazar'];
            $Conceptos->reparar           = $valor['reparar'];
            $Conceptos->fecha_aplicacion  = Carbon::parse($valor['fechaAplicacion'])->timezone('America/Mexico_City')->toDateTimeString();
            $Conceptos->partes            = $valor['costoParte'];
            $Conceptos->mano_obra         = $valor['costoManoObra'];
            $Conceptos->subcontratado     = $valor['costoSubcontratado'];
            $Conceptos->otros             = $valor['costoOtros'];
            $Conceptos->subtotal_costos   = $valor['subTotalCostos'];

            $res = $Conceptos->save();

        }

        if($res){
            return ['estado' => true];
        }
        return ['estado' => false];
    }

    public function delete($numConcepto, $id)
    {
        $Concepto = new pCarrito2023;
        $data['numConcepto'] = $numConcepto;
        $data['id'] = $id;

        $Concepto = $Concepto->where('id','=',$id)->first();
        $Concepto->delete();


        return $data;
    }

    public function delete4($numConcepto, $id)
    {
        $Concepto = new pCarrito;
        $data['numConcepto'] = $numConcepto;
        $data['id'] = $id;

        $Concepto = $Concepto->where('id','=',$id)->first();
        $Concepto->delete();


        return $data;
    }

    public function delete3($numConcepto, $id)
    {
        $Concepto = new pCFECarrito;
        $data['numConcepto'] = $numConcepto;
        $data['id'] = $id;

        $Concepto = $Concepto->where('id','=',$id)->first();
        $Concepto->delete();


        return $data;
    }

    public function deletehoja($id)
    {
        $Concepto = new HojaConcepto;
        $data['id'] = $id;

        $Concepto = $Concepto->where('id','=',$id)->first();
        $Concepto->delete();


        return $data;
    }

    public function reporte($id)
    {
        $HojaConcepto = new HojaConcepto;
        $Concepto     = new pCarrito2023;
      

        $hojaConceptos = $HojaConcepto->where('id', '=', $id)->first();

        $Conceptos = $Concepto->where('presupuesto_id','=',$hojaConceptos->presupuesto_id)->get();

    
        $data = self::getOrdenSeguimiento($hojaConceptos->odes);

        
    

        return View::make('reportes.hojaConceptos') -> with(['reporte' => $data, 'hojaConceptos' => $hojaConceptos, 'conceptos' => $Conceptos]);
    }

    public function reporte4($id)
    {
        $HojaConcepto = new HojaConcepto;
        $Concepto     = new pCarrito;
      

        $hojaConceptos = $HojaConcepto->where('id', '=', $id)->first();

        $Conceptos = $Concepto->where('presupuesto_id','=',$hojaConceptos->presupuesto_id)->get();

    
        $data = self::getOrdenSeguimiento($hojaConceptos->odes);

        
    

        return View::make('reportes.hojaConceptos') -> with(['reporte' => $data, 'hojaConceptos' => $hojaConceptos, 'conceptos' => $Conceptos]);
    }

    public function reporte3($id)
    {
        $HojaConcepto = new HojaConcepto;
        $Concepto     = new pCFECarrito;
      

        $hojaConceptos = $HojaConcepto->where('id', '=', $id)->first();

        $Conceptos = pCFECarrito::join('pCFEConceptos','pCFECarrito.pCFEConcepto_id','=','pCFEConceptos.id')
        ->select('pCFECarrito.id','pCFEConceptos.descripcion','pCFECarrito.cantidad','pCFECarrito.precio as subtotal_costos','pCFECarrito.precio_v','pCFECarrito.remplazar','pCFECarrito.reparar','pCFECarrito.fecha_aplicacion','pCFECarrito.parte as partes','pCFECarrito.mano_obra','pCFECarrito.subcontratado','pCFECarrito.otros','pCFECarrito.proveedor','pCFECarrito.clave','pCFECarrito.status')
        ->where('pCFECarrito.presupuestoCFE_id','=',$hojaConceptos->presupuesto_id)->get();

    
        $data = self::getOrdenSeguimiento($hojaConceptos->odes);

        
    

        return View::make('reportes.hojaConceptos') -> with(['reporte' => $data, 'hojaConceptos' => $hojaConceptos, 'conceptos' => $Conceptos]);
    }

    public function reporteOrden($id)
    {
        $OrdenCompra = new OrdenCompra;
        $HojaConcepto = new HojaConcepto;
        $Concepto     = new Concepto;
      

        $OrdenCompras = $OrdenCompra->where('id', '=', $id)->first();
        $hojaConceptos = $HojaConcepto->where('id', '=', $OrdenCompras->hoja_concepto_id)->first();


        $Conceptos = Concepto::select('id','descripcion','cantidad','precio','proveedor','clave')
        ->where('orden_compra_id','=',$id)->get();
    
        $data = self::getOrdenSeguimiento($hojaConceptos->odes);

        
    

        return View::make('reportes.ordenCompra') -> with(['reporte' => $data, 'hojaConceptos' => $hojaConceptos, 'conceptos' => $Conceptos, 'ordenCompra' => $OrdenCompras]);

        //return View::make('reportes.ordenCompra')->with(['data'=>$data, 'autorizado'=>$OrdenCompra->autorizado, 'firmaRecibido'=>$OrdenCompra->firma_recibido]);
    }

    public function reporteOrden4($id)
    {
        $OrdenCompra = new OrdenCompra;
        $HojaConcepto = new HojaConcepto;
        $Concepto     = new Concepto;
      

        $OrdenCompras = $OrdenCompra->where('id', '=', $id)->first();
        $hojaConceptos = $HojaConcepto->where('id', '=', $OrdenCompras->hoja_concepto_id)->first();


        $Conceptos = Concepto::select('id','descripcion','cantidad','precio','proveedor','clave')
        ->where('orden_compra_id','=',$id)->get();
    
        $data = self::getOrdenSeguimiento($hojaConceptos->odes);

        
    

        return View::make('reportes.ordenCompra') -> with(['reporte' => $data, 'hojaConceptos' => $hojaConceptos, 'conceptos' => $Conceptos, 'ordenCompra' => $OrdenCompras]);

        //return View::make('reportes.ordenCompra')->with(['data'=>$data, 'autorizado'=>$OrdenCompra->autorizado, 'firmaRecibido'=>$OrdenCompra->firma_recibido]);
    }

    public function reporteOrden3($id)
    {
        $OrdenCompra = new OrdenCompra;
        $HojaConcepto = new HojaConcepto;
        $Concepto     = new Concepto;
      

        $OrdenCompras = $OrdenCompra->where('id', '=', $id)->first();
        $hojaConceptos = $HojaConcepto->where('id', '=', $OrdenCompras->hoja_concepto_id)->first();


        $Conceptos = Concepto::select('id','descripcion','cantidad','precio','proveedor','clave')
        ->where('orden_compra_id','=',$id)->get();
    
        $data = self::getOrdenSeguimiento($hojaConceptos->odes);

        
    

        return View::make('reportes.ordenCompra') -> with(['reporte' => $data, 'hojaConceptos' => $hojaConceptos, 'conceptos' => $Conceptos, 'ordenCompra' => $OrdenCompras]);

        //return View::make('reportes.ordenCompra')->with(['data'=>$data, 'autorizado'=>$OrdenCompra->autorizado, 'firmaRecibido'=>$OrdenCompra->firma_recibido]);
    }

 
}