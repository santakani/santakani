<?php

namespace App;

class City extends Translatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city';



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Cover image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }

}
