<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManutencaoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $rotasLivres = [
            'login',
            'manutencao',
            'manutencao-status',
        ];
        $rotaAtual = ltrim($request->path(), '/');
        if (cache('modo_manutencao', false)) {
            // Se rota livre, permite
            if (in_array($rotaAtual, $rotasLivres)) {
                return $next($request);
            }
            // Se não autenticado, redireciona para login
            if (!Auth::check()) {
                return redirect('/login');
            }
            // Se autenticado mas não super-admin, redireciona para manutencao
            if (!(method_exists(Auth::user(), 'isSuperAdmin') && Auth::user()->isSuperAdmin())) {
                return redirect('/manutencao');
            }
            // Se autenticado e super-admin, permite
        }
        return $next($request);
    }
}
