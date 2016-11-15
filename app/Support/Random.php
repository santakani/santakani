<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Support;

use Auth;
use Carbon\Carbon;

/**
 * Generate random seeds and provide random functions.
 */
class Random {
    /**
     * Random seed for the user.
     *
     * @var int
     */
    protected $user_seed;

    /**
     * Get random seed for a user. If not specified, use current user. The seed
     * changes in a certain period. If $period is 0 or null, the seed will not
     * change by time.
     *
     * @param int|\App\User $user The seed for. Default value is current login user.
     * @param int $period How long the random seed change (seconds). Default value one day.
     * @return int
     */
    public static function getUserSeed($user = null, $period = 86400)
    {
        if (empty($user)) {
            // User not set, get current login user
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            }
        } elseif (is_int($user)) {
            // If $user is an ID
            $user_id = $user;
        } elseif (is_object($user) && is_int($user->id)) {
            // If $user is a User object
            $user_id = $user->id;
        }

        if (empty($user_id)) {
            return Carbon::now()->timestamp / $period;
        } else {
            return Carbon::now()->timestamp / $period * $user_id;
        }

    }
}
