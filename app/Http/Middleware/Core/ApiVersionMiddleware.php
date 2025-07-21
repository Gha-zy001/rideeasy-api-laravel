<?php

namespace App\Http\Middleware\Core;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiVersionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $version = $request->header('API-Version', 'v1');

        app()->instance('api.version', $version);

        return $next($request);
    }
}
