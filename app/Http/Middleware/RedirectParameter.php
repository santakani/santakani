<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use Auth;
use Closure;

/**
 * RedirectParameter
 *
 * Read '?redirect=xxx' paramter in URL and save it in session intended URL.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Middleware
 */
class RedirectParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('redirect')) {
            $request->session()->put('url.intended', $request->input('redirect'));
        }

        return $next($request);
    }
}
