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
use Illuminate\Support\Facades\DB;




class CotCreditosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index($id){
        Auth::user()->autorizarRol([1,2]);

        $det = CotCreditosDet::where('id_credito', '=', $id)->get();
        $enc = CotCreditosEnc::where('id_cotizacion', '=', $id)->first();
        $sumMonto = CotCreditosDet::select(DB::raw('SUM(monto_cot) as monto'))
        ->where('id_credito', '=', $id)
        ->first();
        

        return view('cotizacion.cotizacion', compact('enc', 'det', 'sumMonto'));
    }

    public function mostrar($id){
        return view('cotizacion.envioCotizacion', compact('id'));
    }

    public function enviar(Request $request){

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


        $pdf = PDF::loadView('pfd.propuesta', compact('det', 'enc', 'chart'))->setPaper('a4', 'landscape');

        Mail::send('email.emailPropuesta', compact('enc'), function ($mail) use ($correo, $pdf) {
            // $mail->from('ismaelcastillo@analyticsas.com', 'Ismael Castillo');
            $mail->to($correo);
            $mail->attachData($pdf->output(), 'test.pdf');
        });
        
        return $pdf->setPaper('a4', 'landscape')->stream('prouesta.pdf');

        
    }

  public function destroy(Request $request){
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
      $tasaPonderada = $tasaPonderada + ($det->tasa_cot*$det->monto_cot)/$totalMonto;
      $diasPonderados = $diasPonderados + ($det->dias_inventario*$det->monto_cot)/$totalMonto;
    }

    $encabezado = CotCreditosEnc::find($id_propuesta);
    $encabezado->tasa_ponderada = $tasaPonderada;
    $encabezado->dias_ponderados = $diasPonderados;//Se deben poner los días ponderados bien
    $encabezado->save();
 

    return redirect()->route('cotizacion.index', $id_propuesta);
   
  }

  public function update(Request $request){
    
    //monto, tasa, comentarios
    $idDet = $request->idDet;
    $idEnc = $request->idEnc;
    $monto = $request->monto;
    $tasa = $request->monto;
    $comentarios = $request->comentarios;

    $detalle = CotCreditosDet::find($idDet);
    $detalle->monto_cot = $monto;
    $detalle->tasa_cot = $tasa;
    $detalle->comentarios = $comentarios;

    $detalle->save();
    
    return redirect()->route('cotizacion.index', $idEnc);
   
  }

    
}
