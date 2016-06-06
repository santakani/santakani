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
 * Place
 *
 * Model for place page.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Place
 */
class Place extends Model
{
    use SoftDeletes;

    use ImageFeature;
    use TagFeature;
    use TranslateFeature;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'place';

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
    protected $appends = ['name', 'tag_ids', 'url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'city_id', 'image_id', 'address', 'latitude', 'longitude',
        'email', 'phone', 'website', 'facebook', 'google_plus',
    ];

    //====================================================================
    // Relationship Methods
    //====================================================================

    /**
     * Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function country()
    {
        return $this->city->country();
    }

    /**
     * City.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    /**
     * Owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //====================================================================
    // Dynamic Properties
    //====================================================================

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
     * "url" getter. URL of place page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('place/' . $this->id);
    }

    //====================================================================
    // Other Methods
    //====================================================================

    // Todo...

    //====================================================================
    // Static Functions
    //====================================================================

    /**
     * Query places within a radius.
     *
     * @see https://developers.google.com/maps/articles/phpsqlsearch_v3?csw=1#finding-locations-with-mysql
     *
     * @param float $latitude Coordinate of central point. Default is Helsinki.
     * @param float $longitude Coordinate of central point. Default is Helsinki.
     * @param float $radius Max distance from central point. Unit is km.
     * @return \Illuminate\Database\Query\Builder
     */
    public static function scope($latitude = 60.1686973, $longitude = 24.9512867, $radius = 10) {
        $latitude = floatval($latitude);
        $longitude = floatval($longitude);
        $radius = floatval($radius) * 6378.10; // Convert to degree

        return self::having('distance', '<' ,$radius)->select(
            DB::raw("*, (ACOS(COS(RADIANS(?)) * COS(RADIANS(latitude)) * COS(RADIANS(?) - RADIANS(longitude)) + SIN(RADIANS(?)) * SIN(RADIANS(latitude)))) AS distance")
        )->orderBy('distance','asc')->setBindings([$latitude, $longitude, $latitude]);
    }

    /**
     * All possible types of places.
     *
     * @return string[]
     */
    public static function types()
    {
        return array_keys(self::typesWithNames());
    }

    /**
     * All possible types of places.
     *
     * @return array
     */
    public static function typesWithNames()
    {
        return [
            'shop' => 'Shop',
            'studio' => 'Studio',
            'showroom' => 'Showroom',
            'museum' => 'Museum',
            'school' => 'School',
        ];
    }
}
