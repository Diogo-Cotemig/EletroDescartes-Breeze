<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado.');
        }

        // Verificar se o usuário é admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acesso negado. Você não tem permissão de administrador.');
        }

        return $next($request);
    }
}
