<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use Features\TranslationFeature;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'option';

    /**
     * Attributes that will be appeded to Array or JSON output.
     *
     * @var array
     */
    protected $appends = [
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * Design this option belongs to.
     */
    public function design()
    {
        return $this->belongsTo('App\Design');
    }

    /**
     * Cover image for this option.
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    /**
     * "url" getter.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('option/' . $this->id);
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
