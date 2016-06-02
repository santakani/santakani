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
    public function parentPage() {
        return $this->morphTo('parent');
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
     * @param Symfony\Component\HttpFoundation\File\File $file
     */
    public function saveFile(File $file)
    {
        $this->deleteFile(); // Clean directory

        $new_file = $file->move($this->getDirectoryPath(), 'temp');
        $temp_file_path = $this->getDirectoryPath() . '/temp';

        $image = new Imagick($temp_file_path);

        // Read original size. Before this, width and height properties are empty.
        $this->width = $image->getImageWidth();
        $this->height = $image->getImageHeight();
        $this->save();

        // Full size image with small file size.
        $image->thumbnailImage($this->width, $this->height);
        $image->writeImage($this->getFilePath('full'));

        // Large: 1200x1200px
        if ($this->hasSize('large')) {
            $image->readImage($temp_file_path);
            $image->thumbnailImage(self::large_size, self::large_size, true);
            $image->writeImage($this->getFilePath('large'));
        }

        // Medium 600x600px
        if ($this->hasSize('medium')) {
            $image->readImage($temp_file_path);
            $image->thumbnailImage(self::medium_size, self::medium_size, true);
            $image->writeImage($this->getFilePath('medium'));
        }

        // Thumb: 300x300px croped
        $image->readImage($temp_file_path);
        $size = min(self::thumb_size, $this->width, $this->height);
        $image->cropThumbnailImage($size, $size);
        $image->writeImage($this->getFilePath('thumb'));

        $image->destroy();

        unlink($temp_file_path);
    }

    /**
     * Delete all generated image files and folder of this images.
     */
    public function deleteFile() {
        $path = $this->getDirectoryPath();
        if (!is_dir($path)) {
            return;
        }
        $files = array_diff(scandir($path), ['.', '..']);

        foreach ($files as $file) {
            $file_path = $path . '/' . $file;
            if (is_file($file_path)) {
                unlink($file_path);
            }
        }
    }
}
