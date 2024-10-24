<?php

namespace App\Http\Controllers;

use App\RevisionLucesEspias;
use Illuminate\Http\Request;

class RevisionLucesEspiasController extends Controller
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
        $RevisionLucesEspias = new RevisionLucesEspias;
        $RevisionLucesEspias -> codigo = $request -> codigo;
        $RevisionLucesEspias -> save();
        return json_encode($RevisionLucesEspias->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RevisionLucesEspias  $revisionLucesEspias
     * @return \Illuminate\Http\Response
     */
    public function show(RevisionLucesEspias $revisionLucesEspias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RevisionLucesEspias  $revisionLucesEspias
     * @return \Illuminate\Http\Response
     */
    public function edit(RevisionLucesEspias $revisionLucesEspias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RevisionLucesEspias  $revisionLucesEspias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RevisionLucesEspias $revisionLucesEspias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RevisionLucesEspias  $revisionLucesEspias
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisionLucesEspias $revisionLucesEspias)
    {
        //
    }
}
