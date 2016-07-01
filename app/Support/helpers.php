<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Helper functions. All start with "app_" to avoid duplicate.
 */

//===============================================
// Array
//===============================================

if (!function_exists('app_array_filter')) {
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

//===============================================
// URL
//===============================================

if (!function_exists('app_redirect_url')) {
    /**
     * Generate URL with redirect parameter.
     *
     * @param string $base_url
     * @param string $redirect
     */
    function app_redirect_url($base_url, $redirect = null)
    {
        // Do not parse redirect URLs on login and register page, avoid redirect loop.
        if (url()->current() === url('login') || url()->current() === url('register')) {
            return url($base_url);
        }

        if ($redirect === null) {
            $redirect = url()->full();
        }

        return url($base_url . '?redirect=' . urlencode($redirect));
    }
}

//===============================================
// File
//===============================================

if (!function_exists('app_rrmdir')) {
    /**
     * Remove directory recursively. Require full path
     *
     * @param string $dir_path
     */
     function app_rrmdir($dir_path)
     {
         if (is_dir($dir_path)) {
             $objects = scandir($dir_path);
             foreach ($objects as $object) {
                 if ($object !== '.' && $object !== '..') {
                     $object_path = $dir_path . '/' . $object;
                     if (is_dir($object_path)) {
                         self::rrmdir($object_path);
                     } else {
                         unlink($object_path);
                     }
                 }
             }
             rmdir($dir_path);
         }
     }
}