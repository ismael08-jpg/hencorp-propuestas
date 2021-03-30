<?php

namespace App\Http\Controllers;

use App\Models\CotCatalogoCredito;
use App\Models\CotCreditosDet;
use App\Models\CotCreditosEnc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;
use QuickChart;
use App\Mail\PropuestaMailable;
use App\Models\VwSaldosXParticipacion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;




class CotCreditosController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }

    public function index($id){
        $band=0;
        Auth::user()->autorizarRol([1,2]);

        
        $enc = CotCreditosEnc::where('id_cotizacion', '=', $id)->where('usuario_cot', '=', Auth::user()->id)->first();

        if($enc != []){
          $det = CotCreditosDet::where('id_credito', '=', $id)->get();
          $sumMonto = CotCreditosDet::select(DB::raw('SUM(monto_cot) as monto'))
          ->where('id_credito', '=', $id)
          ->first();
          return view('cotizacion.cotizacion', compact('enc', 'det', 'sumMonto', 'band'));
        }else{
          return redirect()->route('catalogo-creditos.index');
        }
    }




    public function mostrar($id){
      Auth::user()->autorizarRol([1,2]);
        return view('cotizacion.envioCotizacion', compact('id'));
    }

    

  public function destroy(Request $request){
    Auth::user()->autorizarRol([1,2]);
    $id_propuesta=0;
    $detalle = CotCreditosDet::find($request->id);
    $id_propuesta = $detalle->id_credito;// Id de la propuesta
    $detalle->delete();

    //Recalculamos la tasa ponderada y los días ponderados.
    $tasaPonderada=0; //Acumula la tasa * NLP
    $diasPonderados=0; 
    $totalMonto=0;

    $detalle = CotCreditosDet::where('id_credito', '=', $id_propuesta)->get();
    
    foreach($detalle as $det){
      $totalMonto = $totalMonto + $det->monto_cot;
    }

    foreach($detalle as $det){
      $catalogo = CotCatalogoCredito::find($det->id_cotizacion);
      $tasaPonderada = $tasaPonderada + ($det->tasa_cot*$det->monto_cot)/$totalMonto;
      $diasPonderados = $diasPonderados + ($catalogo->dias_inventario*$det->monto_cot)/$totalMonto;
    }

    $encabezado = CotCreditosEnc::find($id_propuesta);
    $encabezado->tasa_ponderada = $tasaPonderada;
    $encabezado->dias_ponderados = $diasPonderados;//Se deben poner los días ponderados bien
    $encabezado->save();
 

    return redirect()->route('cotizacion.index', $id_propuesta);
   
  }

  public function update(Request $request){
    Auth::user()->autorizarRol([1,2]);
    $band=0;
    $validacion = $request->validate([
      'tasa' => 'required|numeric|min:0.01',
      'monto' => 'required|numeric|min:0.01',
      'industria' => 'required'
  ]);

    
    //monto, tasa, comentarios
    $idDet = $request->idDet;
    $idEnc = $request->idEnc;
    $monto = $request->monto;
    $tasa = $request->tasa;
    $industria = $request->industria;
    $comentarios = $request->comentarios;

    $detalle = CotCreditosDet::find($idDet);
    $detalle->monto_cot = $monto;
    $detalle->tasa_cot = $tasa;
    $detalle->comentarios = $comentarios;
    $detalle->industria = $industria;
    $detalle->save();

    //Recalculamos La tasa ponderada y los días ponderados.
    $totalMonto = 0;
    $tasaPonderada =0;
    $diasPonderados =0;
    $detalle = CotCreditosDet::where('id_credito', '=', $idEnc)->get();
    
    foreach($detalle as $det){
      $totalMonto = $totalMonto + $det->monto_cot;
    }

    foreach($detalle as $det){
      $catalogo = CotCatalogoCredito::find($det->id_cotizacion);
      $tasaPonderada = $tasaPonderada + ($det->tasa_cot*$det->monto_cot)/$totalMonto;
      $diasPonderados = $diasPonderados + ($catalogo->dias_inventario*$det->monto_cot)/$totalMonto;
    }

    $encabezado = CotCreditosEnc::find($idEnc);
    $encabezado->tasa_ponderada = $tasaPonderada;
    $encabezado->dias_ponderados = $diasPonderados;//Se deben poner los días ponderados bien
    $encabezado->save();
    

    $band=1;
    return redirect()->route('cotizacion.index', $idEnc);
   
  }

  

    
}
