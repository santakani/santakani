<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
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
