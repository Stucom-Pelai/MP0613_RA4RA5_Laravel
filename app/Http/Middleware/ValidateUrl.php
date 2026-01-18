<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Obtener la URL enviada desde el formulario
        $url = $request->input('img_url');

        // Validar si es una URL real
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            // Redirige al home y pasa mensaje de error
            return redirect('/')
                ->with('error', 'La URL no es válida');
        }

        // Si es válida, deja pasar la request
        return $next($request);
    }
}
