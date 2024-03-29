<?php

namespace App\Http\Controllers;

use App\Models\CotCatalogoCredito;
use App\Models\CotCreditosDet;
use App\Models\CotCreditosEnc;
use App\Models\ActivosNoDisponible;
use App\Models\Fecha;
use App\Models\Participante;
use App\Models\VwSaldosXParticipacion;
use App\Models\VwSaldosXCredito;
use App\Models\HencorpPropuestasConfig;
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
        
        
        $participante = DB::table('participante')->distinct()->select('nom_participante')->orderBy('nom_participante', 'ASC')->get();    
        $noDisponibles = ActivosNoDisponible::all();//Deudorres no disponibles
        $mayorA = '';
        $menorA = '';
        $parti = '';
        $monto = '';
        $inversionesDisponibles = [];
        
        $bandera = 0;
        $saldoParti = 0.0;
        

        if (count($filtros) > 0) { 
            $monto = $filtros[0];
            $mayorA = $filtros[1];
            $menorA = $filtros[2];
            $parti = $filtros[3];

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
                if($parametro['saldo']>0.15){
                    array_push($excluci, 
                    [
                        'grupo_economico' => $parametro['grupo_economico']
                    ]); 
                }
            }

            //Orden del catalogo según los creditos y el grupo economico con mayor desponibilidad

           

             //Llamamos los catalogos, en este caso, >= al los filtros indicados en la vista 

            if($mayorA!=null and $menorA !=null ){
                $catalogo = CotCatalogoCredito::where('NLP', '>=', $mayorA)
                ->where('NLP', '<=', $menorA)->where('tasa_credito', '>', 0)
                ->orderby('grupo_economico')
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();

                $catalogoSobra = CotCatalogoCredito::where('NLP', '>=', $mayorA)
                ->where('NLP', '<=', $menorA)->where('tasa_credito', '>', 0)
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();
            } else if($mayorA != null and $menorA == null){
                $catalogo = CotCatalogoCredito::where('NLP', '>=', $mayorA)
                ->where('tasa_credito', '>', 0)
                ->orderby('grupo_economico')
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();

                $catalogoSobra = CotCatalogoCredito::where('NLP', '>=', $mayorA)
                ->where('tasa_credito', '>', 0)
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();
            } else if($menorA!=null and $mayorA==null){
                $catalogo = CotCatalogoCredito::where('NLP', '<=', $menorA)
                ->orderby('grupo_economico', 'desc')
                ->where('tasa_credito', '>', 0)
                ->orderby('grupo_economico')
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();

                $catalogoSobra = CotCatalogoCredito::where('NLP', '<=', $menorA)
                ->orderby('grupo_economico', 'desc')
                ->where('tasa_credito', '>', 0)
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();

            }else{
                $catalogo = CotCatalogoCredito::where('tasa_credito', '>', 0)
                ->orderby('grupo_economico')
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();

                $catalogoSobra = CotCatalogoCredito::where('tasa_credito', '>', 0)
                ->orderBy('NLP', 'desc')
                ->orderby('tasa_credito', 'desc')
                ->get();
            }
            
            

            
            //Llamamos al procedimiento almacenado que nos trae la tabla que define el orden de los catalogos
            $orderTable = DB::select("call consultarOrdenCatalogo()", array());
            session(['ordenCatalogo' => $orderTable]);

            $fechaCartera='0000-00-00';
            
            foreach($orderTable as $or) {   
                foreach($catalogo as $fila){

                    $band = true;
                    //Exclusiones de grupos económicos °:::::::::::::::::°
                    foreach($excluci as $ex){
                        if(strtoupper(trim($fila->grupo_economico)) == strtoupper(trim($ex['grupo_economico']))){
                             $band=false;
                        }
                    }

                    foreach($noDisponibles as $no){
                        if(strtoupper(trim($no->deudor)) == strtoupper(trim($fila->nombre_deudor))){
                            $band=false;
                        }
                    }

                    if($band){
                    
                        
                        if($or->grupo_economico == $fila->grupo_economico){
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
                                    'ESTADO' => $fila->ESTADO,
                                    'pais' => $fila->pais,
                                    'industria' => $fila->industria
                                ]); 
                                $fechaCartera = $fila->fecha_cartera;
                        }
                    }
                }           
            }

           


            foreach($catalogoSobra as $fila) {   
                

                    $band = true;
                    //Exclusiones de grupos económicos °:::::::::::::::::°
                    foreach($excluci as $ex){
                        if(strtoupper(trim($fila->grupo_economico)) == strtoupper(trim($ex['grupo_economico']))){
                             $band=false;
                        }
                    }

                    foreach($orderTable as $or){
                            
                        if($or->grupo_economico == $fila->grupo_economico){
                            $band=false;
                        }
                    }

                    foreach($noDisponibles as $no){
                        if($no->deudor == $fila->nombre_deudor){
                            $band=false;
                        }
                    }
                  
                    

                    if($band){
                    

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
                                'ESTADO' => $fila->ESTADO,
                                'pais' => $fila->pais,
                                'industria' => $fila->industria
                            ]); 
                            $fechaCartera = $fila->fecha_cartera;
                    }
                       
            }
        }else{
            $c=CotCatalogoCredito::select('fecha_cartera')->first();
            $fechaCartera = $c->fecha_cartera->format('d-m-Y');
        }
        
        session(['inversionesDisponibles' => $inversionesDisponibles]);

        if($inversionesDisponibles == []){
            $bandera = 0;
        }

        $parametro = HencorpPropuestasConfig::where('id_config', '=', 1)->first();
        
        return view('catalogo.catalogoCreditos', compact('fechaCartera','inversionesDisponibles', 'saldoParti', 'parti', 'monto', 'bandera', 'participante', 'mayorA', 'menorA', 'parametro'));
    }













    public function postIndex(Request $request) {
        Auth::user()->autorizarRol([1,2]);
        
        $parti = $request->parti;
        $monto = $request->monto;

        if($request->filtrar!=null){
            


            if($request->mayorA!=null and $request->menorA!=null){
                $validacion = $request->validate([
                    'mayorA' => 'required|numeric|min:0.01',
                    'menorA' => 'required|numeric|min:' . (is_numeric($request->mayorA) ? $request->mayorA + 0.01 : 0.01),
                    'parti' => 'required'
                ]);
            }else if ($request->mayorA!=null and $request->menorA==null){
                $validacion = $request->validate([
                    
                    'mayorA' => 'required|numeric|min:0.01',
                    'parti' => 'required'
                ]);
            } else if($request->mayorA==null and $request->menorA!=null){//Esta bien!
                $validacion = $request->validate([
                    'menorA' => 'required|numeric|min:0.01',
                    'parti' => 'required'
                ]);
            }






            $mayorA = $request->mayorA;
            $menorA = $request->menorA;
            return $this->index([$monto, $mayorA, $menorA, $parti]);
        }else if($request->save=!null){
            $monto = $request->montoInput;
            $parti = $request->partiInput;
            return $this->store([$monto, $parti]);
        }    
    }




    //Con esta función guardamos los datos 
    public function store($filtros = []){
        Auth::user()->autorizarRol([1,2]);

        $monto = $filtros[0];
        $parti = $filtros[1];
        $parametro = HencorpPropuestasConfig::where('id_config', '=', 1)->first();
        //$montoTotal = $filtros[2];
        //$parti = $filtros[3];       
        $encabezado = new CotCreditosEnc();
        $calcuTasaPonderada=0; //Acumula la tasa * NLP
        $calcuDiasPonderados=0; 
        $totalNLP=0; 
        $id=0;
        $totalTasa = 0;
        $totalDias = 0;

        if(session('inversionesDisponibles') != null) {
            $now = Carbon::now();
            $encabezado->monto_cot =$monto;
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
                $detalle->id_cotizacion = $inversion['id'];
                $detalle->grupo_economico = $inversion['grupo_economico'];
                $detalle->monto_cot = $inversion['NLP'];
                $detalle->tasa_cot = $inversion['tasa_credito'];
                if(($inversion['tasa_credito']-$parametro->rendimiento_hbc)>=0)
                $detalle->rendimiento = ($inversion['tasa_credito']-$parametro->rendimiento_hbc);
                else
                $detalle->rendimiento = 0.0;
                $detalle->fecha_cot = $inversion['fecha_vencimiento'];
                $detalle->nombre_deudor = $inversion['nombre_deudor'];
                $detalle->pais = $inversion['pais'];
                $detalle->industria = $inversion['industria'];
                $detalle->dias_inventario = $inversion['dias_inventario'];
                $detalle->save();
                $calcuDiasPonderados += (($inversion['dias_inventario']*$inversion['NLP'])/$totalNLP);
                $calcuTasaPonderada += (($inversion['tasa_credito']*$inversion['NLP'])/$totalNLP);
                
            }

            $encabezado->tasa_ponderada = $calcuTasaPonderada;
            $encabezado->dias_ponderados = $calcuDiasPonderados;
            $encabezado->save();
        }
        session(['inversionesDisponibles' => null]);
        
       

        
        
        $id=$encabezado->id_cotizacion;
        return redirect()->route('cotizacion.index', ['id' => $id]);
    }

    
}
