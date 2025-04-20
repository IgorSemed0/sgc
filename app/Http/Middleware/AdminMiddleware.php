<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->tipo_usuario === 'admin') {
            return $next($request);
        }

        abort(404);
        return redirect()->route('home')->with('error', 'Acesso negado. Apenas administradores podem acessar esta área.');
        // return redirect()->route('admin.home')->with('error', 'Acesso negado. Apenas administradores podem acessar esta área.');
    }
}