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
        return view('cotizacion.cotizacion', compact('enc', 'det'));
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

    
}
