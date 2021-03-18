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
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index($id){
        Auth::user()->autorizarRol([1,2]);

        
        $enc = CotCreditosEnc::where('id_cotizacion', '=', $id)->where('usuario_cot', '=', Auth::user()->id)->first();

        if($enc != []){
          $det = CotCreditosDet::where('id_credito', '=', $id)->get();
          $sumMonto = CotCreditosDet::select(DB::raw('SUM(monto_cot) as monto'))
          ->where('id_credito', '=', $id)
          ->first();
          return view('cotizacion.cotizacion', compact('enc', 'det', 'sumMonto'));
        }else{
          return redirect()->route('catalogo-creditos.index');
        }
    }




    public function mostrar($id){
      Auth::user()->autorizarRol([1,2]);
        return view('cotizacion.envioCotizacion', compact('id'));
    }

    public function enviar(Request $request){
      Auth::user()->autorizarRol([1,2]);
        $det = CotCreditosDet::where('id_credito', '=', $request->id)->get();
        $enc = CotCreditosEnc::where('id_cotizacion', '=', $request->id)->first();

        $correo = $request->correo;

        // Código que genera los gráficos

        $chart = new QuickChart(array(
            'width' => 500,
            'height' => 300
          ));
          
          $chart->setConfig('{
            type: "bar",
            "format": "png",
            data: {
              labels: ["Hello world", "Test"],
              datasets: [{
                label: "Foo",
                data: [1, 2]
              }]
            }
          }');

        $data = [
            'titulo' => 'Styde.net'
        ];

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
              'concentracion' => $valor
              
          ]);
        }



        $pdf = PDF::loadView('pfd.propuesta', compact('tablaPdf', 'enc', 'chart', 'tasaPortafolio', 'diasPortafolio', 'totalSaldo'))->setPaper('letter', 'landscape');

        // Mail::send('email.emailPropuesta', compact('enc'), function ($mail) use ($correo, $pdf) {
        //     // $mail->from('ismaelcastillo@analyticsas.com', 'Ismael Castillo');
        //     $mail->to($correo);
        //     $mail->attachData($pdf->output(), 'test.pdf');
        // });
        set_time_limit(60000);
        Mail::to($correo)->send(new PropuestaMailable($enc, $pdf->output()));
        return 'Correo enviado';
        //return $pdf->setPaper('a4', 'landscape')->stream('propuesta.pdf');

        
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
    $validacion = $request->validate([
      'tasa' => 'required|numeric|min:0.01',
      'monto' => 'required|numeric'
  ]);

    Auth::user()->autorizarRol([1,2]);
    //monto, tasa, comentarios
    $idDet = $request->idDet;
    $idEnc = $request->idEnc;
    $monto = $request->monto;
    $tasa = $request->tasa;
    $comentarios = $request->comentarios;

    $detalle = CotCreditosDet::find($idDet);
    $detalle->monto_cot = $monto;
    $detalle->tasa_cot = $tasa;
    $detalle->comentarios = $comentarios;
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

    
    return redirect()->route('cotizacion.index', $idEnc);
   
  }

  

    
}
