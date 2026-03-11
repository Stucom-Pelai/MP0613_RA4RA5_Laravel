<?php

/**
 * @author Maxime Pol Marcet
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateYear
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
        $year = $request->route('year');

        if (isset($year) && (is_null($year) || !is_numeric($year))) {
            return redirect('/');
        }

        return $next($request);
    }
}
