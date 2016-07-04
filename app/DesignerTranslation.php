<?php

namespace App;

use App\Localization\Translation;

class DesignerTranslation extends Translation
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designer_translation';

    /**
     * The attributes that are mass assignable. id, story_id, locale and timestamps
     * are protected from vulnerability.
     *
     * @var array
     */
    protected $fillable = [
        'designer_id', 'locale', 'name', 'tagline', 'content'
    ];
}
