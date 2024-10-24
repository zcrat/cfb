<?php

namespace App\Http\Controllers;

use App\Color;
use App\Http\Requests\ColorFormRequest;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    /**
     * @return mixed
     */
    public function nombres()
    {
        $colores = Color::select('id as code','nombre as label')->get();
        return $colores;
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
     * @param ColorFormRequest $request
     * @return array|\Illuminate\Support\Collection
     */
    public function store(ColorFormRequest $request)
    {
        $color = Color::create($request->all());
        if ($color->id) {
            return collect(
                ['estado' => true, 'empresa' => $color]
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
