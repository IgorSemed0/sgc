<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo_usuario === 'admin' || Auth::user()->tipo_usuario === 'funcionario') {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Acesso negado. Apenas administradores podem acessar esta área.');
        // abort(403, 'Acesso negado. Apenas administradores podem acessar esta área.');
        // abort(404);
        // return redirect()->route('home')->with('error', 'Acesso negado. Apenas administradores podem acessar esta área.');
    }
}