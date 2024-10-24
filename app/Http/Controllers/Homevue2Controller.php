<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Homevue2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('homevue2');
    }
}
