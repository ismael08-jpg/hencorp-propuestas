<?php

namespace App\Http\Controllers;

use App\Models\CotCatalogoCredito;
use App\Models\CotCreditosDet;
use App\Models\CotCreditosEnc;
use App\Models\Fecha;
use App\Models\Participante;
use App\Models\VwSaldosXParticipacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CotCatalogoCreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');   
    }

    public function index($filtros = []){
        Auth::user()->autorizarRol([1,2]);
        
        $catalogo = CotCatalogoCredito::all();
        $participante = DB::table('participante')->distinct()->select('nom_participante')->orderBy('nom_participante', 'ASC')->get();    
        
        $mayorA = '';
        $parti = '';
        $monto = '';
        $inversionesDisponibles = [];
        $bandera = 0;
        $saldoParti = 0.0;
        

        if (count($filtros) > 0) {
            $monto = $filtros[0];
            $parti = $filtros[1];
            $acumuladoInversion = 0;
            $bandera = 1;
            
            //Llama al saldo del partisipante
            $saldoParti = VwSaldosXParticipacion::select(DB::raw('SUM(saldo) as saldo'))
                ->where('nom_participante', '=', $parti)
                ->first();
            //tabla temporal para calcular los grupos económicos que no nos interesan
            $temTableParticipantes = VwSaldosXParticipacion::select('grupo_economico', DB::raw('SUM(saldo) as saldo'))
                ->where('nom_participante', '=', $parti)
                ->groupBy('grupo_economico')
                ->get();


            //gruardamos en la siguente variable la división de cada
            $parametrosParticipantes=[];

            foreach ($temTableParticipantes as $item) {
                if($saldoParti->saldo>0){
                    $var = $item->saldo/$saldoParti->saldo;
                }
                
                array_push($parametrosParticipantes, 
                    [
                        'grupo_economico' => $item->grupo_economico,
                        'saldo' => $var
                    ]); 
            }


            //Exclusi guarda los rupos economicos que debemos excluir del catalogo !important
            $excluci = [];
            foreach ($parametrosParticipantes as $parametro) {
                if($parametro['saldo']>0.2){
                    array_push($excluci, 
                    [
                        'grupo_economico' => $parametro['grupo_economico']
                    ]); 
                }
            }

            /*$catalogo = CotCatalogoCredito::where('NLP', '>', ($monto+$saldoParti->saldo)*0.2 )
                ->orderby('NLP')
                ->get();*/

             //Llamamos los catalogos, en este caso, >= al monto   
            $catalogo = CotCatalogoCredito::where('NLP', '>=', $monto )
                ->orderby('NLP')
                ->get();
            

            
            foreach($catalogo as $fila) {
                //$acumuladoInversion += $fila->NLP;
                //if($acumuladoInversion <= ($monto*1.5)) {
                    $bandera = false;
                    foreach($excluci as $ex){
                        if($fila->grupo_economico != $ex['grupo_economico']){
                             $bandera = true;
                        }
                    }

                    if($bandera){
                        array_push($inversionesDisponibles, 
                            [
                                'id' => $fila->id_credito,
                                'fecha_cartera' => $fila->fecha_cartera,
                                'id_credito' => $fila->id_credito,
                                'nombre_deudor' => $fila->nombre_deudor,
                                'grupo_economico' => $fila->grupo_economico,
                                'cant_participaciones' => $fila->cant_participaciones,
                                'saldo_principal' => $fila->saldo_principal,
                                'tasa_credito' => $fila->tasa_credito,
                                'porc_saldo_principal' => $fila->porc_saldo_principal,
                                'NLP' => $fila->NLP,
                                'costo_ponderado' => $fila->costo_ponderado,
                                'fecha_apertura' => $fila->fecha_apertura,
                                'fecha_vencimiento' => $fila->fecha_vencimiento,
                                'dias_inventario' => $fila->dias_inventario,
                                'dias_al_vencimiento' => $fila->dias_al_vencimiento,
                                'des_linea_negocio' => $fila->des_linea_negocio,
                                'ESTADO' => $fila->ESTADO
                            ]);
                    }
                //}               
            }

            
        }
        
        session(['inversionesDisponibles' => $inversionesDisponibles]);
        
        return view('catalogo.catalogoCreditos', compact('inversionesDisponibles', 'saldoParti', 'parti', 'monto', 'bandera', 'participante'));
    }

    public function postIndex(Request $request) {
        

        if($request->filtrar!=null){
            $validacion = $request->validate([
                'mayorA' => 'required|numeric|min:0.01',
                'parti' => 'required'
            ]);
            $mayorA = $request->mayorA;
            $parti = $request->parti;
            return $this->index([$mayorA, $parti]);
        }else if($request->save=!null){
            $monto = $request->montoInput;
            $saldo = $request->saldo;
            $montoTotal = $request->montoTotal;
            $parti = $request->partiInput;
            return $this->store([$monto, $saldo, $montoTotal, $parti]);
        }    
    }

    public function store($filtros = []){
        Auth::user()->autorizarRol([1,2]);

        $monto = $filtros[0];
        $saldo = $filtros[1];
        $montoTotal = $filtros[2];
        $parti = $filtros[3];       
        $encabezado = new CotCreditosEnc();
        $calcuTasaPonderada=0; //Acumula la tasa * NLP
        $calcuDiasPonderados=0; 
        $totalNLP=0; 
        $id=0;
        $totalTasa = 0;
        $totalDias = 0;

        if(session('inversionesDisponibles') != null) {
            $now = Carbon::now();
            $encabezado->monto_cot =$montoTotal;
            $encabezado->estado_cot = 'A';
            $encabezado->usuario_cot = Auth::user()->id;
            $encabezado->nombre_cotizacion = $parti;
            $encabezado->fecha_cot = $now;
            $encabezado->save();
            
            foreach(session('inversionesDisponibles') as $inversion) {
                $totalNLP =  $totalNLP + $inversion['NLP'];
            }//Calculamos el Total de NLP pra calcular la tasa ponderada y los días ponderados;

            foreach(session('inversionesDisponibles') as $inversion) {
                $detalle = new CotCreditosDet();                   
                $detalle->id_credito = $encabezado->id_cotizacion;
                $detalle->grupo_economico = $inversion['grupo_economico'];
                $detalle->monto_cot = $inversion['NLP'];
                $detalle->tasa_cot = $inversion['tasa_credito'];
                $detalle->fecha_cot = $inversion['fecha_vencimiento'];
                $detalle->nombre_deudor = $inversion['nombre_deudor'];
                $detalle->save();
                $calcuDiasPonderados += (($inversion['dias_inventario']*$inversion['NLP'])/$totalNLP);
                $calcuTasaPonderada += (($inversion['tasa_credito']*$inversion['NLP'])/$totalNLP);
                
            }

            $encabezado->tasa_ponderada = $calcuDiasPonderados;
            $encabezado->dias_ponderados = $calcuTasaPonderada;
            $encabezado->save();
        }
        session(['inversionesDisponibles' => null]);
        
        //Lllamamos a Saldos_X_participacion para obtener el potafolio del participante de la propuesta

        $PortafolioParti = VwSaldosXParticipacion::select('saldo', 'tasa_credito')->
        where('nom_participante', '=', $parti)->get();

        
        
        $id=$encabezado->id_cotizacion;
        //return view('cotizacion.cotizacion', compact('enc', 'det'));
        return redirect()->route('cotizacion.index', ['id' => $id]);
        //return $PortafolioParti;
        

    }

    
}
