<?php

namespace App;

class Tag extends Translatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * Attributes that will be appeded to Array or JSON output.
     *
     * @var array
     */
    protected $appends = [
        'url', 'name'
    ];

    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////



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
        return url('tag/' . $this->id);
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

    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                              Other Methods                             //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


}
