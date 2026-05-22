<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ManutencaoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Rotas que sempre devem estar acessíveis
        $rotasLivres = [
            'login',
            'logout',
            'manutencao',
            'manutencao-status',
            'manutencao-teste'
        ];

        $rotaAtual = ltrim($request->path(), '/');

        // Verifica se o modo manutenção está ativo
        if (Cache::get('modo_manutencao', false)) {
            // Se é uma rota livre, permite acesso
            if (in_array($rotaAtual, $rotasLivres) || str_starts_with($rotaAtual, 'manutencao')) {
                return $next($request);
            }

            // Se é usuário autenticado e super admin, permite acesso total
            if (Auth::check() &&
                method_exists(Auth::user(), 'isSuperAdmin') &&
                Auth::user()->hasRole('super-admin')) {
                return $next($request);
            }

            // Para todos os outros casos (autenticado ou não), redireciona para manutenção
            return redirect('/manutencao');
        }
        
        return $next($request);
    }
}
