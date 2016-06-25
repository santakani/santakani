<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helpers;

/**
 * UrlHelper
 *
 * Helper function for process URLs.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Helper
 */
class UrlHelper {

    /**
     * Remove directory recursively.
     *
     * @param string $dir
     */
    public static function redirectUrl($base_url, $redirect = null)
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
