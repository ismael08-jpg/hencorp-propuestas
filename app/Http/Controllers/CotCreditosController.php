<?php

namespace App\Http\Controllers;
use App\Models\CotCatalogoCredito;
use App\Models\CotCreditosDet;
use App\Models\CotCreditosEnc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CotCreditosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index(){
        Auth::user()->autorizarRol([1,2]);
        //$encabezado = ::all();
        return view('cotizacion.cotizacion');
    }
}
