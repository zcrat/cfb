<?php

namespace App\Http\Controllers;

use App\TipoAuto;
use Illuminate\Http\Request;

class TipoAutoController extends Controller
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
     * @return mixed
     */
    public function nombres(){
        $tipos = TipoAuto::select('id as code','nombre as label')->get();
        return $tipos;
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
     * @param  \App\TipoAuto  $tipoAuto
     * @return \Illuminate\Http\Response
     */
    public function show(TipoAuto $tipoAuto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoAuto  $tipoAuto
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoAuto $tipoAuto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoAuto  $tipoAuto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoAuto $tipoAuto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoAuto  $tipoAuto
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoAuto $tipoAuto)
    {
        //
    }
}
