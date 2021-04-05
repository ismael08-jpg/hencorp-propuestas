<?php

namespace App\Http\Controllers;
use App\Models\CotCreditosDet;
use App\Models\CotCreditosEnc;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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

      public function copiar(Request $request){
        Auth::user()->autorizarRol([1,2]);

        $id_enc = $request->idEnc;
        $parti = $request->participante;

        //Se guardará en este objeto la copia del encabezado
        $copyEnc = new CotCreditosEnc(); 
        //buscamos todos los datos del encabezado a copiar
        $enc = CotCreditosEnc::where('id_cotizacion', '=', $id_enc)->first();
        //todo listo para los encabezados

        //Copiamos El encabezado-------------/----

        $copyEnc->monto_cot = $enc->monto_cot;
        $copyEnc->tasa_ponderada = $enc->tasa_ponderada;
        $copyEnc->dias_ponderados = $enc->dias_ponderados;
        $copyEnc->nombre_cotizacion = $parti;
        $copyEnc->estado_cot = "A";
        $copyEnc->usuario_cot = Auth::user()->id;
        $now = Carbon::now();
        $copyEnc->fecha_cot = $now;
        $copyEnc->save();

        //Ahora haremos lo mismo para los detalles de la cotización
        //Se guardará en este objeto la copia del Detalle_cotizacion
        
        //buscamos todos los datos del detalle a copiar
        $det = CotCreditosDet::where('id_credito', '=', $id_enc)->get();
        // todo listo para los los detalles
        foreach($det as $det){
            $copyDet = new CotCreditosDet(); 
            $copyDet->id_cotizacion = $det->id_cotizacion;
            $copyDet->id_credito = $copyEnc->id_cotizacion;
            $copyDet->nombre_deudor = $det->nombre_deudor;
            $copyDet->grupo_economico = $det->grupo_economico;
            $copyDet->monto_cot = $det->monto_cot;
            $copyDet->tasa_cot = $det->tasa_cot;
            $copyDet->fecha_cot = $det->fecha_cot;
            $copyDet->comentarios = $det->comentarios;
            $copyDet->pais = $det->pais;
            $copyDet->industria = $det->industria;
            $copyDet->save();
            
        }

        return redirect()->route('propuestas.index');


        
      }
}
