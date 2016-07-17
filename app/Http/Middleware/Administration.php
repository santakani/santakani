<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Administration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role === 'admin') {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
