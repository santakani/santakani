<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'address';

    /**
     * Attributes that will be appeded to Array or JSON output.
     *
     * @var array
     */
    protected $appends = [
        //
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','name', 'street', 'postcode', 'city_id', 'phone', 'email',
    ];

    /**
     * Owner of the address.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * City of the address.
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    /**
     * "url" getter.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('address/' . $this->id);
    }
}
