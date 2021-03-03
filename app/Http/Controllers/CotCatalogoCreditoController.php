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
        $participante = DB::table('participante')->distinct()->select('nom_participante')->orderBy('nom_participante')->get();    
        
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
            

            $saldoParti = VwSaldosXParticipacion::select(DB::raw('SUM(saldo) as saldo'))
                ->where('nom_participante', '=', $parti)
                ->first();

            $catalogo = CotCatalogoCredito::where('NLP', '>', ($monto+$saldoParti->saldo)*0.2 )
                ->orderby('NLP')
                ->get();
            
            

            foreach($catalogo as $fila) {
                $acumuladoInversion += $fila->NLP;
                if($acumuladoInversion <= ($monto*1.5)) {
                    array_push($inversionesDisponibles, 
                    [
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
            }

            
            
            // $acumulado = 0;
            // foreach($inversionesDisponibles as $inversion) {
            //     $acumulado += $inversion['NLP'];
            // }

            // return $acumulado;
        }
        
        return view('catalogo.catalogoCreditos', compact('inversionesDisponibles', 'saldoParti', 'parti', 'monto', 'bandera', 'participante'));
    }

    public function postIndex(Request $request) {
        $validacion = $request->validate([
            'mayorA' => 'required|numeric|min:0.01',
            'parti' => 'required'
        ]);

        $mayorA = $request->mayorA;
        $parti = $request->parti;
        
        if($request->filtrar!=null){

            return $this->index([$mayorA, $parti]);
        }else{
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

        
           
        
       
        
        $inversionesDisponibles = [];
        $bandera = 0;
        
        

        if (count($filtros) > 0) {
            
            $acumuladoInversion = 0;

            $catalogo = CotCatalogoCredito::where('NLP', '>', ($monto+$saldo->saldo)*0.2 )
                ->orderby('NLP')
                ->get();
            
            $encabezado = new CotCreditosEnc();
            $detalle = new CotCreditosDet();
            // $curso = new Curso();

            // $curso->nombre=$request->nombre;
            // $curso->descripcion=$request->descripcion;
            // $curso->categoria=$request->categoria;

            // $curso->save();

            $now = Carbon::now();
            $now1 = $now->format('Y-m-d h:i');

            $encabezado->monto_cot =$montoTotal;
            $encabezado->estado_cot = 'A';
            $encabezado->usuario_cot = 'Caonsultor'; //Aquí se debe de poner el usuario del sistema;
            $encabezado->nombre_deudor = $parti;
            $encabezado->fecha_cot = $now;

            $encabezado->save();

            foreach($catalogo as $fila) {
                $acumuladoInversion += $fila->NLP;
                if($acumuladoInversion <= ($monto*1.5)) {
                    array_push($inversionesDisponibles, 
                    [
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
            }

            
            
            // $acumulado = 0;
            // foreach($inversionesDisponibles as $inversion) {
            //     $acumulado += $inversion['NLP'];
            // }

            // return $acumulado;
        }
        
        return view('catalogo.catalogoCreditos', compact('inversionesDisponibles', 'saldoParti', 'parti', 'monto', 'bandera', 'participante'));
    }

    
}
