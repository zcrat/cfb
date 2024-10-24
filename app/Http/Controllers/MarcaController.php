<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaFormRequest;
use App\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
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

    public function nombres(){
        $empresas = Marca::select('id as code','nombre as label')->get();
        return $empresas;
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
     * @param MarcaFormRequest $request
     * @return array|\Illuminate\Support\Collection
     */
    public function store(MarcaFormRequest $request)
    {
        $marca = Marca::create($request->all());
        if ($marca->id) {
            return collect(
                ['estado' => true, 'marca' => $marca]
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
    public function marcas($marca_id){
        $marca = Marca::find($marca_id);
        $marcaModelos = $marca->modelos;
        $modelos = collect();
        foreach($marcaModelos as $modelo){
            $modelos->push(['code' => $modelo->id,'label' => $modelo->nombre]);
        }
        return $modelos;
    }
}
