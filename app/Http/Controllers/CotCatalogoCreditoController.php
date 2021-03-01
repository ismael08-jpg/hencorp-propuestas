<?php

namespace App\Http\Controllers;

use App\Models\CotCatalogoCredito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CotCatalogoCreditoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index( Request $request){
        Auth::user()->autorizarRol([1,2]);
        $catalogo = CotCatalogoCredito::paginate(7);
        return view('catalogo.catalogoCreditos', compact('catalogo'));
    }
}
