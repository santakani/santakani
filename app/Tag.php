<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use Features\EditLockFeature;
    use Features\ImageFeature;
    use Features\LikeFeature;
    use Features\TranslationFeature;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'locked_at'];

    /**
     * Attributes that will be appeded to Array or JSON output.
     *
     * @var array
     */
    protected $appends = [
        'url', 'name', 'search_index'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['image_id', 'level'];

    //==========================================================================
    // Relationship Methods
    //==========================================================================

    public function designers()
    {
        return $this->morphedByMany('App\Designer', 'taggable', 'taggable');
    }

    public function places()
    {
        return $this->morphedByMany('App\Place', 'taggable', 'taggable');
    }

    public function stories()
    {
        return $this->morphedByMany('App\Story', 'taggable', 'taggable');
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

    /**
     * "search_index" getter.
     *
     * @return string
     */
    public function getSearchIndexAttribute()
    {
        $search_index = '';
        foreach ($this->translations as $translation) {
            $search_index .= $translation->name;
        }
        return $search_index;
    }

    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                              Other Methods                             //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


}
