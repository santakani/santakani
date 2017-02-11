<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use claviska\SimpleImage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use Features\TransferFeature;

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
     * Image thumbnail file name and sizes
     * @var array
     */
    protected $sizes = [
        // Keep image proportion
        'small' => [
            'width' => 300,
            'height' => 300,
            'crop' => false,
            'fallback' => 'full',
        ],
        'medium' => [
            'width' => 600,
            'height' => 600,
            'crop' => false,
            'fallback' => 'full',
        ],
        'large' => [
            'width' => 1200,
            'height' => 1200,
            'crop' => false,
            'fallback' => 'full',
        ],

        // Crop to square
        'thumb' => [
            'width' => 300,
            'height' => 300,
            'crop' => true,
            'fallback' => false,
        ],
        'largethumb' => [
            'width' => 600,
            'height' => 600,
            'crop' => true,
            'fallback' => 'thumb',
        ],
    ];

    /**
     * Allowed MIME types
     *
     * @var array
     */
    protected $mimes = [
        'image/jpeg' => [
            'extension' => '.jpg',
        ],
        'image/png' => [
            'extension' => '.png',
        ],
        'image/gif' => [
            'extension' => '.gif',
        ],
    ];

    /**
     * Image storage path related to public folder
     *
     * @var string
     */
    protected $storage = 'storage/images';


    //==========================================================================
    // Parent methods override
    //==========================================================================

    /**
     * Delete image files and database records
     */
    public function deleteWithFiles()
    {
        $this->deleteDirectory();
        $this->delete();
    }

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
    public function parent()
    {
        return $this->morphTo();
    }


    //==============================================
    // Dynamic properties
    //==============================================

    /**
     * Getter of "url". URL to image page, not image file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('image/' . $this->id);
    }

    /**
     * Getter of "extension", file extension.
     *
     * @return string|null
     */
    public function getExtensionAttribute()
    {
        if (isset($this->mimes[$this->mime_type]['extension'])) {
            return $this->mimes[$this->mime_type]['extension'];
        } else {
            return null;
        }
    }

    /**
     * Getter of "directory_path".
     *
     * @return string Absolute path related to system root. /srv/www/public/storage/images/100/100
     */
    public function getDirectoryPathAttribute()
    {
        return public_path($this->storage.'/'.(int)($this->id/1000).'/'.($this->id % 1000));
    }

    /**
     * Getter of "directory_url".
     *
     * @return string URL to the image directory.
     */
    public function getDirectoryUrlAttribute()
    {
        return url($this->storage.'/'.(int)($this->id/1000).'/'.($this->id % 1000));
    }

    /**
     * Getter of "full_file_url".
     *
     * @return string
     */
    public function getFullFileUrlAttribute()
    {
        return $this->fileUrl('full');
    }

    /**
     * Getter of "large_file_url".
     *
     * @return string
     */
    public function getLargeFileUrlAttribute()
    {
        return $this->fileUrl('large');
    }

    /**
     * Getter of "medium_file_url".
     *
     * @return string
     */
    public function getMediumFileUrlAttribute()
    {
        return $this->fileUrl('medium');
    }

    /**
     * Getter of "thumb_file_url".
     *
     * @return string
     */
    public function getSmallFileUrlAttribute()
    {
        return $this->fileUrl('small');
    }

    /**
     * Getter of "thumb_file_url".
     *
     * @return string
     */
    public function getThumbFileUrlAttribute()
    {
        return $this->fileUrl('thumb');
    }

    /**
     * Getter of "largethumb_file_url".
     *
     * @return string
     */
    public function getLargethumbFileUrlAttribute()
    {
        return $this->fileUrl('largethumb');
    }


    //==============================================
    // File Information
    //==============================================

    /**
     * Get fallback size if the original image is not big enough
     *
     * @param string $size
     * @return string
     */
    public function fallback($size)
    {
        if (empty($this->sizes[$size])) {
            return 'full';
        }

        if (!$this->sizes[$size]['fallback']) {
            return $size;
        }

        if ($this->sizes[$size]['crop']) {
            if ($this->width >= $this->sizes[$size]['width'] && $this->height >= $this->sizes[$size]['height']) {
                return $size;
            } else {
                return $this->fallback($this->sizes[$size]['fallback']);
            }
        } else {
            if ($this->width > $this->sizes[$size]['width'] || $this->height > $this->sizes[$size]['height']) {
                return $size;
            } else {
                return $this->fallback($this->sizes[$size]['fallback']);
            }
        }
    }

    /**
     * Detect if a size exists
     *
     * @param string $size
     * @return boolean
     */
    public function has($size)
    {
        if (empty($this->sizes[$size])) {
            return false;
        }

        if (!$this->sizes[$size]['fallback']) {
            return true;
        }

        if ($this->sizes[$size]['crop']) {
            return $this->width >= $this->sizes[$size]['width'] && $this->height >= $this->sizes[$size]['height'];
        } else {
            return $this->width > $this->sizes[$size]['width'] || $this->height > $this->sizes[$size]['height'];
        }
    }

    /**
     * Generate full path to image file
     *
     * @param string $size One of full, large, medium, small, thumb, largethumb.
     * @return string
     */
    public function filePath($size = 'full')
    {
        return $this->directory_path . '/' . $size . $this->extension;
    }

    /**
     * Generate URL to image file
     *
     * @param string $size One of full, large, medium, small, thumb, largethumb.
     * @return string
     */
    public function fileUrl($size = 'full')
    {
        $size = $this->fallback($size);
        return $this->directory_url . '/' . $size . $this->extension;
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
    public function saveFile($temp_file_path)
    {
        // Create an empty new folder
        $this->deleteDirectory();
        $this->createDirectory();

        // SimpleImage instances
        $image = new SimpleImage();

        // Compressed full size image
        $image->fromFile($temp_file_path)->autoOrient()->toFile($this->filePath('full'));

        $this->generateThumbnails();
    }

    /**
     * Regenerate thumbnail image files.
     */
    public function generateThumbnails()
    {
        $image = new SimpleImage();
        $image->fromFile($this->filePath('full'));

        foreach ($this->sizes as $size => $info) {
            if (!$this->has($size)) {
                continue;
            }

            $img = clone $image;

            if ($info['crop']) {
                $img->thumbnail($info['width'], $info['height']);
            } else {
                $img->bestFit($info['width'], $info['height'], true);
            }

            $img->toFile($this->filePath($size));
        }
    }

    /**
     * Create directory for saving images.
     */
    public function createDirectory()
    {
        mkdir($this->directory_path, 0755, true);
    }

    /**
     * Delete all generated image files and folder of this images.
     */
    public function deleteDirectory()
    {
        app_rrmdir($this->directory_path);
    }
}
