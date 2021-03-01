<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $redireccion = '';
                
                switch(Auth::user()->tipo_usuario){
                    case 1:
                        $redireccion = '/admin/index';
                    break;
                    case 2:
                        $redireccion = '/catalogo-creditos';
                    break;
                }

                return redirect($redireccion);
            }
        }

        return $next($request);
    }
}
