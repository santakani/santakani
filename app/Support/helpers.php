<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (! function_exists('app_array_filter')) {
    /**
     * Get a subset of the items from the given array. DO NOT fill non-exist
     * keys with null. (different from array_only() function)
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function app_array_filter($array, $keys)
    {
        $results = [];
        foreach ($keys as $key) {
            if (array_has($array, $key)) {
                array_set($results, $key, array_get($array, $key));
            }
        }
        return $results;
    }
}
