<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*', // Excluir todas as rotas do CSRF
    ];

    public function handle(Request $request, Closure $next)
    {
        // Retorna a requisição diretamente, ignorando qualquer validação de CSRF
        return $next($request);
    }    
}
