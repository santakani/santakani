<?php

namespace App;

use App\Localization\Translation;

class CityTranslation extends Translation
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city_translation';

    /**
     * The attributes that are mass assignable. id, story_id, locale and timestamps
     * are protected from vulnerability.
     *
     * @var array
     */
    protected $fillable = [
        'city_id', 'locale', 'name', 'content',
    ];
}
