<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotCatalogoCredito;
use App\Models\CotCreditosDet;
use App\Models\CotCreditosEnc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;
use QuickChart;
use App\Mail\PropuestaMailable;
use App\Models\VwSaldosXParticipacion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

class EnvioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }
    public function mostrar(){
        return view('cotizacion.envioCotizacion');
    }

    public function index(){
        
        return redirect()->route('propuestas.index');
        
    }


    public function enviar(Request $request){
        Auth::user()->autorizarRol([1,2]);
          $det = CotCreditosDet::where('id_credito', '=', $request->id)->get();
          $enc = CotCreditosEnc::where('id_cotizacion', '=', $request->id)->first();
  
          $correo = $request->correo;
  
          $saldoParti = VwSaldosXParticipacion::select(DB::raw('SUM(saldo) as saldo'))
          ->where('nom_participante', '=', $enc->nombre_cotizacion)
          ->first();
  
          $porce = VwSaldosXParticipacion::select(DB::raw('SUM(saldo) as saldo'), 'grupo_economico')
          ->where('nom_participante', '=', $enc->nombre_cotizacion)
          ->groupBy('grupo_economico')
          ->get();
          $now = Carbon::now();
  
  
  
           //Lllamamos a Saldos_X_participacion para obtener el potafolio del participante de la propuesta    
           $PortafolioParti = VwSaldosXParticipacion::select('saldo', 'tasa_interes', 'fecha_vencimiento')
          ->where('nom_participante', '=', $enc->nombre_cotizacion)->get();
          $tasaPortafolio=0;
          $diasPortafolio=0;
          $totalSaldo=0;
  
  
          //Calculo de días al vencimiento
  
          foreach ($PortafolioParti as $porta){
            $totalSaldo += $porta->saldo;
           }
  
           $fechaActual = new DateTime(date('Y-m-d'));
           
          foreach($PortafolioParti as $porta){ 
            $fecha = new DateTime($porta->fecha_vencimiento);
            $diff = $fecha->diff($fechaActual);
            $diff->days;
  
            $tasaPortafolio += (($porta->tasa_interes*$porta->saldo)/$totalSaldo);
            $diasPortafolio += (($diff->days*$porta->saldo)/$totalSaldo);
          }
  
          
  
          //----------------------------
          $contacto =  Auth::user()->email;
          $tablaPdf=[];
  
          foreach($porce as $por){
          if($saldoParti->saldo>0)
          $por->saldo=($por->saldo/$saldoParti->saldo)*100;
          else
          $por->saldo = 0;
            
  
          }
  
          foreach($det as $det){
            $bandera=true;
            $valor = 0;
            foreach($porce as $por){
              if($por->grupo_economico == $det->grupo_economico)
              {
                $valor = $por->saldo;
              }
            }
            array_push($tablaPdf, 
            [
                'id_cotizacion' => $det->id_cotizacion,
                'id_credito' => $det->id_credito,
                'nombre_deudor' => $det->nombre_deudor,
                'grupo_economico' => $det->grupo_economico,
                'monto_cot' => $det->monto_cot,
                'tasa_cot' => $det->tasa_cot,
                'fecha_cot' => $det->fecha_cot,
                'comentarios' => $det->comentarios,
                'pais' => $det->pais,
                'industria' => $det->industria,
                'concentracion' => $valor
                
            ]);
          }
  
  
  
          $pdf = PDF::loadView('pfd.propuesta', compact('tablaPdf', 'contacto', 'enc', 'tasaPortafolio', 'diasPortafolio', 'totalSaldo'))->setPaper('letter', 'landscape');
  
          
          set_time_limit(60000);
          Mail::to($correo)->send(new PropuestaMailable($enc, $pdf->output()));
          $encEstado = CotCreditosEnc::find($request->id);
          $encEstado->estado_cot = 'B';
          $encEstado->save();
  
          return $pdf->setPaper('a4', 'landscape')->stream('propuesta.pdf'); 
      }




}
