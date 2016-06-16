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
     * The attributes that are managed by accessor and mutator functions.
     * See https://laravel.com/docs/5.2/eloquent-mutators
     *
     * @var array
     */
    protected $appends = [
        'url', 'file_urls'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mime_type', 'width', 'height'];

    /**
     * Large size of images (large).
     *
     * @var int
     */
    const large_size = 1200;

    /**
     * Medium size of images (medium).
     *
     * @var int
     */
    const medium_size = 600;

    /**
     * Size of image thumbnails, crop to square (thumb).
     *
     * @var int
     */
    const thumb_size = 300;

    /**
     * Root directory of image storage, related to /public directory.
     *
     * @var string
     */
    const image_storage_path = 'storage/image';

    /**
     * Allowed MIME types for files. video/youtube and video/vimeo are not included.
     *
     * @var array
     */
    protected $allowed_mime_types = [
        'image/jpeg', 'image/png', 'image/gif',
    ];

    /**
     * Image sizes that will be generated.
     *
     * @var array
     */
    protected $image_sizes = [
        'full', 'large', 'medium', 'thumb',
    ];



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * Owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Parent model. By default, function name must be same with *_type and *_id
     * columns. But we can pass a string parameter to morphTo() function to define
     * custom column name. Then we can rename this function to whatever we like.
     * @see \App\Designer::images()
     * @see \App\Place::images()
     * @see \App\Country::images()
     * @see \App\City::images()
     *
     * @return mixed
     */
    public function parent() {
        return $this->morphTo();
    }



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                           Dynamic Properties                           //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * "url" getter.
     *
     * Note this is the URL to image page, not image file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('image/' . $this->id);
    }

    /**
     * "file_urls" getter.
     *
     * URL to image files. Contain for sizes: full, large, medium, thumb.
     * Mainly used to send to browser.
     * TODO implement client side logic to generate file urls
     *
     * [Example]
     *
     * [
     *     'full' => 'http://santakani.com/storage/image/0/1/full.jpg',
     *     'large' => 'http://santakani.com/storage/image/0/1/large.jpg',
     *     'medium' => 'http://santakani.com/storage/image/0/1/medium.jpg',
     *     'thumb' => 'http://santakani.com/storage/image/0/1/thumb.jpg',
     * ]
     *
     * @return string[]
     */
    public function getFileUrlsAttribute()
    {
        return [
            'full' => $this->getFileUrl('full'),
            'large' => $this->getFileUrl('large'),
            'medium' => $this->getFileUrl('medium'),
            'thumb' => $this->getFileUrl('thumb'),
        ];
    }



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                              Other Methods                             //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * Get file extension of image file based on MIME type.
     *
     * @return string
     */
    public function getFileExtension()
    {
        switch ($this->mime_type) {
            case 'image/jpeg':
                return '.jpg';
            case 'image/png':
                return '.png';
            case 'image/gif':
                return '.gif';
            default:
                return null;
        }
    }

    /**
     * Get fallback size if the original image is not big enough
     *
     * @param string $size
     *
     * @return string
     */
    public function sizeFallback($size)
    {
        return $this->hasSize($size)?$size:'full';
    }

    /**
     * Detect if a size exists
     *
     * @param string $size
     *
     * @return boolean
     */
    public function hasSize($size)
    {
        if (!in_array($size, $this->image_sizes)) {
            return false;
        } elseif ($size === 'large') {
            if ($this->width <= self::large_size && $this->height <= self::large_size) {
                return false;
            }
        } elseif ($size === 'medium') {
            if ($this->width <= self::medium_size && $this->height <= self::medium_size) {
                return false;
            }
        }

        return true;
    }

    /**
     * Generate full/relative path to image directory
     *
     * [Example]
     * Image id: 1009768
     * Full path: /srv/www/santakani.com/public/storage/image/1009/768
     * Relative path: storage/image/1009/768
     *
     * @param boolean $full Return full path or relative path.
     * @return string
     */
    public function getDirectoryPath($full = true)
    {
        $id = $this->id;
        $path = self::image_storage_path . '/' . (int)($id/1000) . '/' . $id%1000;

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
    public function getFilePath($size = 'full', $full = true, $size_fallback = false)
    {
        if ($size_fallback) {
            $size = $this->sizeFallback($size);
        }
        return $this->getDirectoryPath($full) . '/' . $size . $this->getFileExtension();
    }

    /**
     * Generate URL to image file
     *
     * @param string $size One of full, large, medium, thumb
     * @param boolean $size_fallback If check fallback sizes.
     * @return string
     */
    public function getFileUrl($size = 'full', $size_fallback = true)
    {
        return url($this->getFilePath($size, false, $size_fallback));
    }

    /**
     * Save image file and generate sizes.
     *
     * @param string $temp_file_path
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
        $imagick->writeImage($this->getFilePath('full'));
        chmod($this->getFilePath('full'), 0644);

        // Large
        if ($this->hasSize('large')) {
            $imagick->thumbnailImage(self::large_size, self::large_size, true);
            $imagick->writeImage($this->getFilePath('large'));
            chmod($this->getFilePath('large'), 0644);
        }

        // Medium
        if ($this->hasSize('medium')) {
            $imagick->thumbnailImage(self::medium_size, self::medium_size, true);
            $imagick->writeImage($this->getFilePath('medium'));
            chmod($this->getFilePath('medium'), 0644);
        }

        // Thumb
        $thumb_imagick->cropThumbnailImage(self::thumb_size, self::thumb_size);
        $thumb_imagick->writeImage($this->getFilePath('thumb'));
        chmod($this->getFilePath('thumb'), 0644);

        $imagick->destroy();

        if ($delete_origin) {
            unlink($temp_file_path);
        }
    }

    /**
     * Create directory for saving images.
     */
    public function createDirectory()
    {
        mkdir($this->getDirectoryPath(), 0755, true);
    }

    /**
     * Delete all generated image files and folder of this images.
     */
    public function deleteDirectory()
    {
        FileHelper::rrmdir($this->getDirectoryPath());
    }
}
