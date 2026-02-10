<?php

/**
 * @author Maxime Pol Marcet
 */

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
        // I check whether an image URL is present in the request.
        if ($request->has('img_url')) {
            $url = $request->input('img_url');

            // Diagram Flow: if url invalid -> welcome(error)
            // If the URL is not valid, I redirect to home ('/') and attach an error message.
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return redirect('/')
                    ->withErrors(['img_url' => 'Error: The provided URL is not valid.'])
                    ->withInput();
            }
        }

        return $next($request);
    }
}