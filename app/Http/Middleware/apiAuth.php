<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class apiAuth
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
        if (!in_array($request->ip() ,explode(',',env('API_WHITELIST')))) {
        // here instead of checking a single ip address we can do collection of ips
        //address in constant file and check with in_array function
            return abort(401);
        }

        return $next($request);
    }
}
