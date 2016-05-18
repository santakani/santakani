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

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Designer
 *
 * Model for designer page.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Designer
 */
class Designer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designer';

    /**
     * The attributes that are managed by accessor and mutator functions.
     * @see https://laravel.com/docs/5.2/eloquent-mutators
     *
     * @var array
     */
    protected $appends = [
        'url'
    ];



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
        return $this->belongsTo('App\Country');
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

    /**
     * Get translations. Used to auto-generate attribute translation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function translations()
    {
        return $this->hasMany('App\DesignerTranslation');
    }



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                           Dynamic Properties                           //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


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

    /**
     * Get translated text from translations. Support fallback if language not
     * available.
     *
     * @param string $field  Field name, like "name", "tagline", "content".
     * @param string $locale Language code, optional. If not set, use English(en).
     * @return string
     */
    public function text($field, $locale = 'en') {
        return $this->translations()->where('locale', $locale)->first()->$field;
    }

}
