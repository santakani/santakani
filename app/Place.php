<?php

/*
 * This file is part of Santakani
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

    use Features\EditLockFeature;
    use Features\ImageFeature;
    use Features\LikeFeature;
    use Features\TagFeature;
    use Features\TransferFeature;
    use Features\TranslationFeature;

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
    protected $dates = ['deleted_at', 'locked_at'];

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
        'email', 'phone', 'website', 'facebook', 'tag_ids', 'gallery_image_ids',
    ];

    /**
     * Children properties that should be transfered with parent. Key is property
     * name and value is boolean: if the child is a collection.
     *
     * @var array
     */
    protected $transfer_children = ['images' => true];

    //====================================================================
    // Management Methods
    //====================================================================

    /**
     * Soft delete with relationships.
     */
    public function deleteWithRelationships()
    {
        $this->delete();
    }

    /**
     * Restore with relationships.
     */
    public function restoreWithRelationships()
    {
        $this->restore();
    }

    /**
     * Hard delete with relationships.
     */
    public function forceDeleteWithRelationships()
    {
        // Hard delete images with files
        foreach ($this->images as $image) {
            $image->deleteWithFiles();
        }

        // Hard delete likes
        $this->likes()->delete();

        // Detach tags
        $this->tags()->detach();

        $this->forceDelete();
    }

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

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city->full_name;
    }

    /**
     * bing_map_url getter.
     *
     * @return string
     */
    public function getBingMapUrlAttribute()
    {
        return 'https://www.bing.com/maps/?where1=' . urlencode($this->full_address);
    }

    /**
     * google_map_url getter.
     *
     * @return string
     */
    public function getGoogleMapUrlAttribute()
    {
        return 'https://www.google.com/maps/search/' . urlencode($this->full_address);
    }

    /**
     * here_map_url getter. Whitespace --> %20. Here Map does not '+' in URL.
     *
     * @return string
     */
    public function getHereMapUrlAttribute()
    {
        return 'https://maps.here.com/search/' . rawurlencode($this->full_address);
    }

    /**
     * open_street_map_url getter.
     *
     * @return string
     */
    public function getOpenStreetMapUrlAttribute()
    {
        return 'https://www.openstreetmap.org/search?query=' . urlencode($this->full_address);
    }

    /**
     * geo_url
     *
     * @see https://en.wikipedia.org/wiki/Geo_URI_scheme
     *
     * @return string
     */
    public function getGeoUrl()
    {
        return 'geo:' . $this->latitude . ',' . $this->longitude;
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
        return ['shop', 'studio', 'showroom', 'museum', 'school'];
    }

    /**
     * All possible types of places.
     *
     * @return array
     */
    public static function typeNames()
    {
        $names = [];

        foreach (self::types() as $key) {
            $names[$key] = trans('place.'.$key);
        }

        return $names;
    }
}
