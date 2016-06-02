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
     * "image_ids" getter.
     *
     * @return int[]
     */
    public function getImageIdsAttribute()
    {
        $image_ids = [];

        foreach ($this->images as $image) {
            $image_ids[] = $image->id;
        }

        return $image_ids;
    }

    /**
     * "gallery_images" getter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function getGalleryImagesAttribute()
    {
        return $this->images()->where('weight', '>', 0)->orderBy('weight', 'desc')->get();
    }

    /**
     * "gallery_image_ids" setter.
     *
     * @param int[] image_ids Ordered list of image ids.
     */
    public function setGalleryImageIdsAttribute($image_ids)
    {
        $image_ids = array_intersect($image_ids, $this->image_ids);
        $hide_image_ids = array_diff($this->image_ids, $image_ids);

        $weight = 1;
        foreach ($image_ids as $image_id) {
            $image = Image::find($image_id);
            $image->weight = $weight;
            $image->save();
            $weight++;
        }

        foreach ($hide_image_ids as $image_id) {
            $image = Image::find($image_id);
            $image->weight = null;
            $image->save();
        }
    }

    /**
     * "gallery_image_ids" getter.
     *
     * @return int[]
     */
    public function getGalleryImageIdsAttribute()
    {
        $image_ids = [];

        foreach ($this->gallery_images as $image) {
            $image_ids[] = $image->id;
        }

        return $image_ids;
    }

}