<?php

namespace App;

use App\Localization\Translation;

class TagTranslation extends Translation
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag_translation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tag_id', 'locale', 'name', 'alias', 'description'];
}
