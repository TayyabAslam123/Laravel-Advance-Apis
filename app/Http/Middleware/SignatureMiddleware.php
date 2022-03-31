<?php

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $headerName = 'X-Name')
    {   $response = $next($request);
        $response->headers->set($headerName , config('app.name'));
        // $response->header('access-control-allow-origin','*');
        return $response;
        
        //return $next($request);
    }
}
