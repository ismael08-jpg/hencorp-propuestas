<?php

namespace App\Http\Controllers;
use App\Models\CotCreditosDet;
use App\Models\CotCreditosEnc;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MisPropuestasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index(){
        Auth::user()->autorizarRol([1,2]);
        $idUser = Auth::user()->id;
       
    
        $enc = CotCreditosEnc::where('usuario_cot', '=', $idUser)->get();

        $estado=[];
        $conta=0;
               
        return view('cotizacion.misPropuestas', compact('enc', 'estado', $idUser));
      }
}
