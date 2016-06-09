<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;

class User extends Authenticatable
{
    use SoftDeletes;

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
        'name', 'email', 'password', 'api_token', 'facebook_id', 'google_id',
        'twitter_id',
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
     * All defined roles.
     *
     * @var array
     */
    protected $defined_roles = [
        'admin', 'editor', 'translator'
    ];



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * User uploaded images.
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }

    /**
     * User created designer pages.
     */
    public function designers()
    {
        return $this->hasMany('App\Designer');
    }

    /**
     * User created place pages.
     */
    public function places()
    {
        return $this->hasMany('App\Place');
    }

    //====================================================================
    // Dynamic Properties
    //====================================================================

    //====================================================================
    // Avatar Methods
    //====================================================================

    /*
     * Currently, we do not support upload avatar to server. Instead, use various
     * avatar providers. The order is: Facebook, Google, Twitter, Gravatar. Google
     * and Twitter avatar need to call API, so implemented in JavaScript.
     */

    /**
     * Get Facebook avatar URL. Note that returned image size is not exact value.
     *
     * @see https://developers.facebook.com/docs/graph-api/reference/v2.2/user/picture
     *
     * @param int $size
     * @return string
     */
    public function facebookAvatar($size)
    {
        return 'http://graph.facebook.com/' . $this->facebook_id . '/picture?type=square'
            . '&width=' . $size . '&height=' . $size;
    }

    /**
     * Get Gravatar URL.
     *
     * @see https://cn.gravatar.com/site/implement/
     *
     * @param int $size
     * @return string
     */
    public function gravatar($size)
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $this->email ) ) );
        $url .= "?s=$size&d=mm&r=g";
        return $url;
    }

    //====================================================================
    // Role Methods
    //====================================================================


    /**
     * Get all roles of the user.
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = [];

        $user_roles = DB::table('user_role')->select('role')
            ->where('user_id', $this->id)->get();

        foreach ($user_roles as $user_role) {
            $role = $user_role->role;
            if (in_array($role, $this->defined_roles)) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    /**
     * Check if user has a role.
     *
     * @param string $role
     */
    public function hasRole($role)
    {
        if (!in_array($role, $this->defined_roles)) {
            return false;
        }

        $user_roles = DB::table('user_role')->where([
            ['user_id', $this->id],
            ['role', $role],
        ])->get();

        return !empty($user_roles);
    }

    /**
     * Assign a role to the user.
     *
     * @param string $role
     */
    public function addRole($role)
    {
        if (!in_array($role, $this->defined_roles)) {
            return;
        }

        if ($this->hasRole($role)) {
            return;
        }

        DB::table('user_role')->insert([
            'user_id' => $this->id,
            'role' => $role,
        ]);
    }

    /**
     * Remove a role from the user.
     *
     * @param string $role
     */
    public function removeRole($role)
    {
        if (!in_array($role, $this->defined_roles)) {
            return;
        }

        if (!$this->hasRole($role)) {
            return;
        }

        DB::table('user_role')->where([
            ['user_id', $this->id],
            ['role', $role],
        ])->delete();
    }
}
