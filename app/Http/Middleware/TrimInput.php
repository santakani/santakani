<?php

namespace App\Http\Middleware;

use Closure;

class TrimInput {

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
        $result = false;

        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $result = true;
            } elseif (is_array($value)) {
                if ($this->is_string_array($value)) {
                    $result = true;
                }
            }
        }

        return $result;
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
