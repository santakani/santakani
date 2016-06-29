<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'place_translation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_id', 'locale', 'name', 'content',
    ];
}
