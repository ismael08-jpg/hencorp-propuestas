<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'usuario';
    }

    public function redirectPath()
    {
        $redireccion = '';
        switch(Auth::user()->tipo_usuario){
            case 1:
                $redireccion = '/admin/index';
            break;
            case 2:
                $redireccion = '/catalogo-creditos';
            break;
        }

        return $redireccion;
    }

    public function loggedOut(Request $request){
        return redirect('/login');
    }
}
