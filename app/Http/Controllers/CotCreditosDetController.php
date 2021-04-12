<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotCatalogoCredito;
use App\Models\CotCreditosDet;
use App\Models\User;
use App\Models\CotCreditosEnc;
use Illuminate\Support\Facades\Auth;

class CotCreditosDetController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }

    public function index(){
        Auth::user()->autorizarRol([1]);

        $enc =  CotCreditosEnc::addSelect(['usuario' => User::select('usuario')
            ->whereColumn('id', 'usuario_cot')
        ])->get();


        return view('administrador.gestionarPropuestas', compact('enc'));
    }

    public function update(Request $request){
        Auth::user()->autorizarRol([1]);

        $band=0;
        $validacion = $request->validate([
            'idEnc' => 'required|numeric',
            'monto' => 'required|numeric|min:0.01',
            'participante' => 'required'
        ]);

        $idEnc = $request->idEnc;
        $monto = $request->monto;
        $parti = $request->participante;
        

        $encabezado = CotCreditosEnc::find($idEnc);
        $encabezado->monto_cot = $monto;
        $encabezado->nombre_cotizacion = $parti;
        
        $encabezado->save();

    
        
        return redirect()->route('admin.gestion', $idEnc);
    }

}
