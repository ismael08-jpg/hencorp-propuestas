<?php

namespace App\Http\Controllers;

use App\Models\CotCatalogoCredito;
use Illuminate\Http\Request;

class CotCatalogoCreditoController extends Controller
{
    public function index(){
        $catalogo=CotCatalogoCredito::paginate();
        return view('catalogo.catalogoCreditos', compact('catalogo'));  
    }
}
