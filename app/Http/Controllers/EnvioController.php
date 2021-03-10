<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnvioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }
    public function mostrar(){
        return view('cotizacion.envioCotizacion');
    }

}
