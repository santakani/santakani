<?php

namespace App;

class Country extends Translatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * Attributes that will be appeded to Array or JSON output.
     *
     * @var array
     */
    protected $appends = [
        'url', 'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * Cover image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                           Dynamic Properties                           //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * "url" getter.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('country/' . $this->id);
    }

    /**
     * "name" getter.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->text('name');
    }
}
