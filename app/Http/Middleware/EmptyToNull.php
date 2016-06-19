<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use Closure;

/**
 * EmptyToNull
 *
 * Convert empty string inputs in request to null. It can affect child arrays
 * recursively.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Middleware
 */
class EmptyToNull {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($request->all() as $key => $value) {
            if ($value === '') {
                $request->merge([$key => null]);
            } elseif (is_array($value)) {
                if ($this->hasEmpty($value)) {
                    $request->merge([$key => $this->arrayNull($value)]);
                }
            }
        }

        return $next($request);
    }

    protected function hasEmpty($array)
    {
        foreach ($array as $item) {
            if (is_array($item)) {
                if ($this->hasEmpty($item)) {
                    return true;
                }
            } elseif ($item === '') {
                return true;
            }
        }

        return false;
    }

    protected function arrayNull($array)
    {
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                $array[$key] = $this->arrayNull($item);
            } elseif ($item === '') {
                $array[$key] = null;
            }
        }

        return $array;
    }
}
