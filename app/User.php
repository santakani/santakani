<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Imagick;

use App\Helpers\FileHelper;

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


    //====================================================================
    // Constants
    //====================================================================

    const avatar_storage_path = 'storage/avatars';

    const avatar_large_size = 300;

    const avatar_medium_size = 150;

    const avatar_small_size = 50;

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

    public function getAvatarFileUrl($size = 'medium')
    {
        if ($this->avatar_uploaded_at) {
            if (is_integer($size)) {
                if ($size > 150) {
                    $size = 'large';
                } elseif ($size > 50) {
                    $size = 'medium';
                } else {
                    $size = 'small';
                }
            }
            return url($this->getAvatarFilePath($size, false)) . '?v=' .
                urlencode($this->avatar_uploaded_at);
        } else{
            if (is_string($size)) {
                if ($size === 'large') {
                    $size = self::avatar_large_size;
                } elseif ($size === 'small') {
                    $size = self::avatar_small_size;
                } else {
                    $size = self::avatar_medium_size;
                }
            }
            if ($this->facebook_id) {
                return $this->facebookAvatar($size);
            } else {
                return $this->gravatar($size);
            }
        }
    }

    public function getAvatarDirectoryPath($full = true)
    {
        $id = $this->id;
        $path = self::avatar_storage_path . '/' . (int)($this->id / 1000) . '/' . $this->id % 1000;

        return $full?public_path($path):$path;
    }

    public function getAvatarFilePath($size = 'medium', $full = true)
    {
        if (!in_array($size, ['large', 'medium', 'small'])) {
            $size = 'medium';
        }

        $path = $this->getAvatarDirectoryPath(false) . '/' . $size;

        return $full?public_path($path):$path;
    }

    public function saveAvatarFile($temp_file_path, $delete_origin = true)
    {
        $this->removeAvatarDirectory();
        $this->createAvatarDirectory();

        $imagick = new Imagick($temp_file_path);

        $path = $this->getAvatarFilePath('large');
        $size = self::avatar_large_size;
        $imagick->cropThumbnailImage($size, $size);
        $imagick->writeImage($path);
        chmod($path, 0644);

        $path = $this->getAvatarFilePath('medium');
        $size = self::avatar_medium_size;
        $imagick->cropThumbnailImage($size, $size);
        $imagick->writeImage($path);
        chmod($path, 0644);

        $path = $this->getAvatarFilePath('small');
        $size = self::avatar_small_size;
        $imagick->cropThumbnailImage($size, $size);
        $imagick->writeImage($path);
        chmod($path, 0644);

        $imagick->destroy();

        if ($delete_origin) {
            unlink($temp_file_path);
        }
    }

    public function createAvatarDirectory()
    {
        mkdir($this->getAvatarDirectoryPath(), 0755, true);
    }

    public function removeAvatarDirectory()
    {
        $path = $this->getAvatarDirectoryPath();
        if (is_dir($path)) {
            FileHelper::rrmdir($path);
        } elseif (is_file($path)) {
            unlink($path);
        }
    }

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
