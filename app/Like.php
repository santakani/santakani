<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Like
 *
 * Model for like.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Like
 */
class Like extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'like';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['likeable_type', 'likeable_id', 'user_id'];


    //==========================================================================
    // Relationship Methods
    //==========================================================================

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
