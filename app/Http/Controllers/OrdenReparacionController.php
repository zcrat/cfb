<?php

namespace App\Http\Controllers;

use App\OrdenReparacion;
use Illuminate\Http\Request;
use App\RecepcionVehicular;
use App\Vehiculo;
use App\Empresa;
use App\Marca;
use App\Cliente;
use App\Modelo;
use App\Persona;

class OrdenReparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrdenReparacion  $ordenReparacion
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenReparacion $ordenReparacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrdenReparacion  $ordenReparacion
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenReparacion $ordenReparacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrdenReparacion  $ordenReparacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenReparacion $ordenReparacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrdenReparacion  $ordenReparacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenReparacion $ordenReparacion)
    {
        //
    }

    public function getRecepcion($or)
    {
        $RecepcionVehicular = new RecepcionVehicular;
        
        $Vehiculo = new Vehiculo;
        $Marca    = new Marca;
        $Modelo   = new Modelo; 
        $Persona  = new Persona;

        $data = [];

        $RecepcionVehicular = $RecepcionVehicular->where('orden_seguimiento',$or)->first();
        if($RecepcionVehicular){
            if($RecepcionVehicular->empresa_id != null){
                $Empresa = new Empresa;
                $Empresa = $Empresa->where('id',$RecepcionVehicular->empresa_id)->first();
                $data['cliente'] = $Empresa;
            }else{
                $Cliente = new Cliente;
                $Cliente = $Cliente->where('id',$RecepcionVehicular->customer_id)->first();
                $data['cliente'] = $Cliente;
            }
            $Persona = $Persona->where('id',$RecepcionVehicular->id_tecnico)->first();
            $Vehiculo = $Vehiculo->where('id',$RecepcionVehicular->vehiculo_id)->first();
            $Marca = $Marca->where('id',$Vehiculo->marca_id)->first();
            $Modelo = $Modelo->where('id',$Vehiculo->modelo_id)->first();

            $data['tecnico']            = $Persona;
            $data['recepcionVehicular'] = $RecepcionVehicular;
            $data['vehiculo']           = $Vehiculo;
            $data['marca']              = $Marca;
            $data['modelo']             = $Modelo;

            return $data;
        }else{
            return 'no hay nada';
        }
        

        //return $RecepcionVehicular;
    }
}
