<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
class Autenticado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

       if (Auth::check() == false) {
           return redirect("/")->with('naoautorizado', "ERRO!! Área Restrita. Faça Login");
       }else{
           return $next($request);
       }
    }
}
