<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Imagick;
use Symfony\Component\HttpFoundation\File\File;

class Image extends Model
{
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
        'url', 'file_extension', 'file_urls'
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

    /**
     * Getter of url.
     * Note this is the URL to image page, not image file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('image/' . $this->id);
    }

    /**
     * If the image is an image file.
     *
     * @return boolean
     */
    public function isImage()
    {
        return substr($this->mime_type, 0, 5) === 'image';
    }

    /**
     * If the image is an external video.
     *
     * @return boolean
     */
    public function isVideo()
    {
        return substr($this->mime_type, 0, 5) === 'video';
    }

    /**
     * Getter of attribute "file_extension".
     * Get file extension of image file based on MIME type.
     *
     * @return string
     */
    public function getFileExtensionAttribute()
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
            if ($this->width <= self::large_size && $this->width <= self::large_size) {
                return false;
            }
        } elseif ($size === 'medium') {
            if ($this->width <= self::medium_size && $this->width <= self::medium_size) {
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
        if (!$this->isImage()) {
            return null;
        }

        return $this->getDirectoryPath($full) . '/' . $size . $this->file_extension;
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
        if (!$this->isImage()) {
            return null;
        }

        return url($this->getFilePath($size, false, $size_fallback));
    }

    /**
     * Getter of file_urls.
     * URL to image files. Contain for sizes: full, large, medium, thumb.
     *
     * @return string[]
     */
    public function getFileUrlsAttribute()
    {
        if (!$this->isImage()) {
            return null;
        }

        return [
            'full' => $this->getFileUrl('full'),
            'large' => $this->getFileUrl('large'),
            'medium' => $this->getFileUrl('medium'),
            'thumb' => $this->getFileUrl('thumb'),
        ];
    }

    /**
     * Save image file and generate sizes.
     *
     * @param Symfony\Component\HttpFoundation\File\File $file
     */
    public function saveFile(File $file)
    {
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



    // Static Helper Functions

    /**
     * Check if the image file MIME type is allowed.
     *
     * @param string $mime_type
     *
     * @return boolean
     */
    public static function checkMimeType($mime_type)
    {
        $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];
        return in_array($mime_type, $allowed_mime_types);
    }

    /**
     * Check if the URL is valid Vimeo url.
     *
     * @param string $url
     *
     * @return boolean
     */
    public static function checkVideoUrl($url)
    {
        return self::checkYouTubeUrl($url) || self::checkVimoeUrl($url);
    }

    /**
     * Check if the URL is valid YouTube url.
     *
     * @param string $url
     *
     * @return boolean
     */
    public static function checkYouTubeUrl($url)
    {
        $result = parse_url($url);

        if ($result['host'] === 'www.youtube.com' && $result['path'] === '/watch'
            && strpos($result['query'], 'v=') !== false) {
            // https://www.youtube.com/watch?v=2CGbyz8UzCY
            return true;
        } elseif ($result['host'] === 'youtu.be') {
            // https://youtu.be/2CGbyz8UzCY
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the URL is valid Vimeo url.
     *
     * @param string $url
     *
     * @return boolean
     */
    public static function checkVimeoUrl($url)
    {
        $result = parse_url($url);

        // https://vimeo.com/162349501
        if ($result['host'] === 'vimeo.com') {
            return true;
        } else {
            return false;
        }
    }

    // TODO toArray() and toJSON() functions.
}
