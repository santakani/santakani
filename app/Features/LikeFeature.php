<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Features;

use Auth;

/**
 * LikeFeature
 *
 * Functions to get and set relationships with Like model.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Like
 */

trait LikeFeature {
    /**
     * Likes assigned to this page/model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    /**
     * Count likes again and save to database.
     */
    public function updateLikeCount()
    {
        $this->like_count = $this->likes()->count();
        $this->save();
    }

    /**
     * "liked" getter. If current user liked this page/model.
     *
     * @return boolean
     */
    public function getLikedAttribute() {
        if (Auth::check()) {
            $like = $this->likes()->where( 'user_id', Auth::user()->id )->first();
            return !empty($like);
        } else {
            return false;
        }
    }
}
