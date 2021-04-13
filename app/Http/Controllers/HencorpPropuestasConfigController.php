<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HencorpPropuestasConfig;

class HencorpPropuestasConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request) {
        Auth::user()->autorizarRol(1);

        $validacion = $request->validate([
            'id' => 'required|numeric',
            'rendimientohbc' => 'required|numeric|min:0.00'
        ]);

        $conf = HencorpPropuestasConfig::find($request->id);
        $conf->rendimiento_hbc = $request->rendimientohbc;
        $conf->save();
        return redirect()->route('catalogo-creditos.index');
    }
}
