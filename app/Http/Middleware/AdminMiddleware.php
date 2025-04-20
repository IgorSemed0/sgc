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

        return redirect()->route('admin.dashboard')->with('error', 'Acesso negado. Apenas administradores podem acessar esta área.');
    }
}