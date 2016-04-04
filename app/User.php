<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Change table name from users to user.
     * 
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Generate URL to avatar file
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return '/storage/avatar/' . (int)($this->id/1000) . '/' . $this->id%1000;
    }
}
