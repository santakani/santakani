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

/**
 * TagFeature
 *
 * Functions to get and set relationships with Tag model.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Tag
 */

trait TagFeature {

    /**
     * Tags assigned to this page/model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function tags()
    {
        /**
         * First "taggable" is name for column *_type, *_id, and tabble. But
         * Laravel guess that your table is "taggables". So we pass second "taggable"
         * as table name.
         * @see https://laravel.com/api/5.2/Illuminate/Database/Eloquent/Model.html#method_morphToMany
         */
        return $this->morphToMany('App\Tag', 'taggable', 'taggable');
    }

    /**
     * "tag_ids" getter.
     *
     * @return int[]
     */
    public function getTagIdsAttribute()
    {
        return $this->tags->pluck('id');
    }

    /**
     * "tag_ids" setter. A convenient way to reset tag relationships.
     *
     * @param int[] $tag_ids An array of tag ids.
     */
    public function setTagIdsAttribute($tag_ids)
    {
        $this->tags()->sync($tag_ids);
    }

}
