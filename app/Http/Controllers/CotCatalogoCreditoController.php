<?php

namespace App\Http\Controllers;

use App\Models\CotCatalogoCredito;
use Illuminate\Http\Request;

class CotCatalogoCreditoController extends Controller
{
    public function index( Request $request){
        $may_men = $request;

        if($may_men->mayor_a!=null)
        $catalogo =  CotCatalogoCredito::where('NLP', '>', $may_men->mayor_a)->where('NLP', '<', $may_men->menor_a)->paginate(10);    
        else
        $catalogo=CotCatalogoCredito::paginate(7);
        return view('catalogo.catalogoCreditos', compact('catalogo'));
        
    }
}
