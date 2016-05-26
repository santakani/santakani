<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Place extends Translatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'place';



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
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
     * Cover Image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
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



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                            Static Functions                            //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * Query places within a radius.
     *
     * @see https://developers.google.com/maps/articles/phpsqlsearch_v3?csw=1#finding-locations-with-mysql
     *
     * @param float $latitude Coordinate of central point.
     * @param float $longitude Coordinate of central point.
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
}
