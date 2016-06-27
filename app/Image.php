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
use Illuminate\Database\Eloquent\SoftDeletes;
use Imagick;
use Symfony\Component\HttpFoundation\File\File;

use App\Helpers\FileHelper;

/**
 * Image
 *
 * Model for image meta data. Be responsible for provide image data and manage
 * uploaded files.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Image
 */

class Image extends Model
{
    use SoftDeletes;

    use LikeFeature;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mime_type', 'width', 'height', 'weight'];

    /**
     * Large size of images.
     *
     * @var int
     */
    const large_size = 1200;

    /**
     * Medium size of images.
     *
     * @var int
     */
    const medium_size = 600;

    /**
     * Size of image thumbnails, crop to square.
     *
     * @var int
     */
    const thumb_size = 300;

    /**
     * Root directory of image storage, related to /public directory.
     *
     * @var string
     */
    const storage_path = 'storage/images';



    //==============================================
    // Relationships
    //==============================================

    /**
     * Owner.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Parent model.
     */
    public function parent() {
        return $this->morphTo();
    }



    //==============================================
    // File Information
    //==============================================

    /**
     * Get file extension of image file based on MIME type.
     *
     * @return string
     */
    public function extension()
    {
        switch ($this->mime_type) {
            case 'image/jpeg':
                return '.jpg';
            case 'image/png':
                return '.png';
            case 'image/gif':
                return '.gif';
            default:
                return '';
        }
    }

    /**
     * Get fallback size if the original image is not big enough
     *
     * @param string $size
     * @return string
     */
    public function fallback($size)
    {
        return $this->has($size)?$size:'full';
    }

    /**
     * Detect if a size exists
     *
     * @param string $size
     * @return boolean
     */
    public function has($size)
    {
        if ($size === 'full' or $size === 'thumb') {
            return true;
        } elseif ($this->width > self::large_size || $this->height > self::large_size) {
            return true; // large, medium
        } elseif ($size === 'medium' && ($this->width > self::medium_size || $this->height > self::medium_size)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate full/relative path to image directory. For example:
     * Image id: 1009768
     * Full path: /srv/www/santakani.com/public/storage/images/1009/768
     * Relative path: storage/images/1009/768
     *
     * @param boolean $full Return full path or relative path. Default true.
     * @return string
     */
    public function directory($full = true)
    {
        $path = self::storage_path.'/'.(int)($this->id/1000).'/'.($this->id % 1000);
        return $full?public_path($path):$path;
    }

    /**
     * Generate full/relative path to image file
     *
     * @param string $size One of full, large, medium, thumb
     * @param boolean $full Return full path or relative path.
     * @param boolean $size_fallback If check fallback sizes.
     * @return string
     */
    public function file($size = 'full', $full = true, $size_fallback = false)
    {
        if ($size_fallback) {
            $size = $this->fallback($size);
        }
        return $this->directory($full) . '/' . $size . $this->extension();
    }

    /**
     * Generate URL to image file
     *
     * @param string $size One of full, large, medium, thumb
     * @param boolean $size_fallback If check fallback sizes.
     * @return string
     */
    public function url($size = 'full', $size_fallback = true)
    {
        return url($this->file($size, false, $size_fallback));
    }



    //==============================================
    // File System Operations
    //==============================================

    /**
     * Save image file and generate sizes. You can choose keep original file or not.
     *
     * @param string $temp_file_path
     * @param boolean $delete_origin
     */
    public function saveFile($temp_file_path, $delete_origin = true)
    {
        // Create an empty new folder
        $this->deleteDirectory();
        $this->createDirectory();

        // Imagick instances
        $imagick = new Imagick($temp_file_path);
        $thumb_imagick = clone $imagick;

        // Full (reduce file size)
        $imagick->thumbnailImage($this->width, $this->height);
        $imagick->writeImage($this->file('full'));
        chmod($this->file('full'), 0644);

        // Large
        if ($this->has('large')) {
            $imagick->thumbnailImage(self::large_size, self::large_size, true);
            $imagick->writeImage($this->file('large'));
            chmod($this->file('large'), 0644);
        }

        // Medium
        if ($this->has('medium')) {
            $imagick->thumbnailImage(self::medium_size, self::medium_size, true);
            $imagick->writeImage($this->file('medium'));
            chmod($this->file('medium'), 0644);
        }

        $imagick->destroy();

        // Thumb
        $thumb_imagick->cropThumbnailImage(self::thumb_size, self::thumb_size);
        $thumb_imagick->writeImage($this->file('thumb'));
        chmod($this->file('thumb'), 0644);

        $thumb_imagick->destroy();

        if ($delete_origin) {
            unlink($temp_file_path);
        }
    }

    /**
     * Create directory for saving images.
     */
    public function createDirectory()
    {
        mkdir($this->directory(), 0755, true);
    }

    /**
     * Delete all generated image files and folder of this images.
     */
    public function deleteDirectory()
    {
        app_rrmdir($this->directory());
    }
}
