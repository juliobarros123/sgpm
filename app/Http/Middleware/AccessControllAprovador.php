<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessControllAprovador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(auth()->check());

        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->perfil !== 'aprovador') {
            return redirect('/pedidos');
            // return redirect('/acesso-negado');
        }

        return $next($request);


    }
}
