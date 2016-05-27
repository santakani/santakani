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

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Designer
 *
 * Model for designer page.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Designer
 */
class Designer extends Translatable
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designer';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Dynamic properties that should be included in toArray() or toJSON().
     *
     * @var array
     */
    protected $appends = ['name', 'tagline', 'tag_ids', 'url'];



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * Owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get country that the designer is located.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Get city that the designer is located.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    /**
     * Get the cover image, used for page banner and thumbnail.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    /**
     * Get Images uploaded to this designer page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'parent');
    }

    /**
     * Get tags that the designer is related to.
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



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                           Dynamic Properties                           //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * "name" getter.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->text('name');
    }

    /**
     * "tagline" getter.
     *
     * @return string
     */
    public function getTaglineAttribute()
    {
        return $this->text('tagline');
    }

    /**
     * "tag_ids" getter. Return an array of tag ids.
     *
     * @return int[]
     */
    public function getTagIdsAttribute()
    {
        $ids = [];
        foreach ($this->tags as $tag) {
            $ids[] = $tag->id;
        }
        return $ids;
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

    /**
     * "url" getter. URL of designer page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('designer/' . $this->id);
    }



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                              Other Methods                             //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


}
