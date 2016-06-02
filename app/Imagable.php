<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

/**
 * Imagable
 *
 * Functions to get and set relationships with image model.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Image
 */

trait Imagable {

    /**
     * Main image, avatar, cover.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    /**
     * Images uploaded to this page/model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'parent');
    }

    /**
     * "gallery_images" getter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function getGalleryImagesAttribute()
    {
        return $this->images()->where('weight', '>', 0)->get();
    }

}
