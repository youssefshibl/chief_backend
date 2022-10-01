<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * this middleware is used to allow cross-origin requests
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof \Illuminate\Http\Response) {
            return $response
                ->header('Access-Control-Allow-Origin', '*');
        }
        return $response;
        // return $next($request)
        // ->header('Access-Control-Allow-Origin', 'http://localhost:3001');
    }
}
