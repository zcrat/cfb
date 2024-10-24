<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehiculoFormRequest;
use App\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = Vehiculo::all();
        $vehiculosColeccion = collect();
        foreach ($vehiculos as $vehiculo){
            $vehiculosColeccion->push(['code'=> $vehiculo->id,'label' => "$vehiculo->no_economico - $vehiculo->placas"]);
        }
        return $vehiculosColeccion;

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
     * @param VehiculoFormRequest $request
     * @return array|\Illuminate\Support\Collection
     */
    public function store(VehiculoFormRequest $request)
    {
        
      
        $vehiculo = Vehiculo::create($request->all());
       
       
        if ($vehiculo->id) {
            return collect(
                ['estado' => true, 'vehiculo' => $vehiculo]
            );
        }
        return ['estado' => false];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
