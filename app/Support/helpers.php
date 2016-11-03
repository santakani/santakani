<?php

/*
 * This file is part of Santakani
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
// String
//===============================================

if (!function_exists('app_empty_text')) {
    /**
     * Check if a UTF-8 string is empty. Whitespaces and line breaks are ignored.
     *
     * @param  string $text
     * @return boolean
     */
    function app_empty_text($text)
    {
        if (empty($text)) {
            return true;
        } else {
            $text = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $text); // Trim
            return empty($text);
        }
    }
}

if (!function_exists('app_empty_html')) {
    /**
     * Check if HTML(UTF-8) is empty. HTML tag, whitespaces and line breaks are ignored.
     *
     * @param  string $html
     * @return boolean
     */
    function app_empty_html($html)
    {
        if (empty($html)) {
            return true;
        } else {
            $text = html_entity_decode(strip_tags($html)); // Remove markups
            $text = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $text); // Trim
            return empty($text);
        }
    }
}

if (!function_exists('html_purify')) {
    /**
     * Remove JavaScript and other unsafe things from HTML.
     *
     * @param  string $html
     * @return string
     */
    function html_purify($html)
    {
        $html_purifier_cache_path = storage_path('app/cache/html_purifier');
        if (!file_exists($html_purifier_cache_path)) {
            mkdir($html_purifier_cache_path, 0775, true);
        }
        $html_purifier_config = HTMLPurifier_Config::createDefault();
        $html_purifier_config->set('Cache.SerializerPath', $html_purifier_cache_path);
        //allow iframes from trusted sources
        $html_purifier_config->set('HTML.SafeIframe', true);
        $html_purifier_config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%'); //allow YouTube and Vimeo
        $html_purifier = new HTMLPurifier($html_purifier_config);
        return $html_purifier->purify($html);
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
