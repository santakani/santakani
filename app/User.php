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
     * All defined roles.
     *
     * @var array
     */
    protected $roles = [
        'admin', 'editor', 'translator'
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

        foreach ($user_roles as $key => $value) {
            if (in_array($value, $this->roles)) {
                $roles[] = $value;
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
        if (!in_array($role, $this->roles)) {
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
        if (!in_array($role, $this->roles)) {
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
        if (!in_array($role, $this->roles)) {
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
