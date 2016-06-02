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



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                           Dynamic Properties                           //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                              Role Methods                              //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


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
