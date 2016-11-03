<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Features;

use App\User;

/**
 * Transfer model ownership to another user.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Transfer
 */

trait TransferFeature {

    /**
     * Transfer image to another user.
     *
     * @param \App\User|int $user
     * @return boolean Transfer succeeded or failed
     */
    public function transfer($user)
    {
        if (empty($user)) {
            return false;
        }

        if (is_object($user)) {
            $user_id = $user->id;
        } else {
            $user_id = (int) $user;
        }

        $this->user_id = $user_id;

        // Save without update timestamps
        $timestamps_enabled = $this->timestamps;
        $this->timestamps = false;
        $this->save();
        $this->timestamps = $timestamps_enabled;

        if ($this->transfer_children) {
            foreach ($this->transfer_children as $children_key => $is_collection) {
                if ($is_collection) {
                    foreach ($this->$children_key as $model) {
                        $model->transfer($user);
                    }
                } else {
                    $this->$children_key->transfer($user);
                }

            }
        }

        return true;
    }

}
