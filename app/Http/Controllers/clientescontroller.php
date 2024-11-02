<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class clientescontroller extends Controller
{
    public function index()
    {
        return view('pruebas.usuarios');
    }
    public function empresas()
    {
        return view('pruebas.empresas');
    }
}
