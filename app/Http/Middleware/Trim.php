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
 * Trim
 *
 * Trim string input. It can affect child arrays recursively.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Middleware
 */
class Trim {

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
            if (is_string($value)) {
                $request->merge([$key => trim($value)]);
            } elseif ($this->is_string_array($value)) {
                $request->merge([$key => $this->trim_array($value)]);
            }
        }

        return $next($request);
    }

    /**
     * Check if an array contains strings.
     *
     * @param array $array
     * @return boolean
     */
    public function is_string_array($array)
    {
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                return true;
            } elseif (is_array($value)) {
                if ($this->is_string_array($value)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Trim strings in an array.
     *
     * @param array $array
     * @return boolean
     */
    public function trim_array($array)
    {
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $array[$key] = trim($value);
            } elseif (is_array($value)) {
                $array[$key] = $this->trim_array($value);
            }
        }

        return $array;
    }
}
