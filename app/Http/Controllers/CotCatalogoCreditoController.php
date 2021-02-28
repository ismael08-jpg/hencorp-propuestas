<?php

namespace App\Http\Controllers;

use App\Models\CotCatalogoCredito;
use Illuminate\Http\Request;

class CotCatalogoCreditoController extends Controller
{
    public function index($filtros = []){
        $catalogo = CotCatalogoCredito::all();
        $mayorA = '';
        $menorA = '';

        if (count($filtros) > 0) {
            $mayorA = $filtros[0];
            $menorA = $filtros[1];
            $catalogo = CotCatalogoCredito::where('NLP', '>', $mayorA)
                ->where('NLP', '<', $menorA)
                ->get();
        }
        
        return view('catalogo.catalogoCreditos', compact('catalogo', 'mayorA', 'menorA'));
    }

    public function postIndex(Request $request) {
        $validacion = $request->validate([
            'mayorA' => 'required|numeric|min:0.01',
            'menorA' => 'required|numeric|min:' . (is_numeric($request->mayorA) ? $request->mayorA + 0.01 : 0.01),
        ]);

        $mayorA = $request->mayorA;
        $menorA = $request->menorA;

        return $this->index([$mayorA, $menorA]);
    }
}
