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
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Diagram Flow: validateUrl()
        // Aquí compruebo si me llega una URL de imagen.
        if ($request->has('img_url')) {
            $url = $request->input('img_url');

            // Diagram Flow: if url invalid -> welcome(error)
            // Si la URL no tiene un formato válido, redirijo al usuario al inicio ('/') y le mando un mensaje de error.
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return redirect('/')
                    ->withErrors(['img_url' => 'Error: La URL proporcionada no es válida.'])
                    ->withInput();
            }
        }

        return $next($request);
    }
}