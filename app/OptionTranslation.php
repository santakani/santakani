<?php

namespace App;

class OptionTranslation extends Translation
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'option_translation';

    /**
     * The attributes that are mass assignable. id, story_id, locale and timestamps
     * are protected from vulnerability.
     *
     * @var array
     */
    protected $fillable = [
        'option_id', 'locale', 'name',
    ];
}
