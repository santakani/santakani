<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

/**
 * StoryTranslation
 *
 * Model for story translation.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Story
 */
class StoryTranslation extends Translation
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'story_translation';

    /**
     * The attributes that are mass assignable. id, story_id, locale and timestamps
     * are protected from vulnerability.
     *
     * @var array
     */
    protected $fillable = [
        'story_id', 'locale', 'title', 'content',
    ];
}
