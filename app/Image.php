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
     * Large size of images (large). Images larger than this value will be scaled.
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
     * Small size of images (small).
     *
     * @var int
     */
    const small_size = 300;

    /**
     * Size of image thumbnails, crop to square (thumb).
     *
     * @var int
     */
    const thumb_size = 300;

    /**
     * Size of image thumbnails, crop to square (thumb).
     *
     * @var int
     */
    const small_thumb_size = 150;

    /**
     * Get file extension of image file based on MIME type
     *
     * @return string
     */
    public function getFileExtension()
    {
        switch ($this->mime_type) {
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
            default:
                $ext = '';
                break;
        }

        return $ext;
    }

    /**
     * Get fallback size if the original image is not big enough
     *
     * @param string $size
     *
     * @return string
     */
    public function getFallbackSize($size)
    {
        if ($size === 'large' && $this->width <= self::medium_size && $this->width <= self::medium_size) {
            $size = 'medium';
        }

        if ($size === 'medium' && $this->width <= self::small_size && $this->width <= self::small_size) {
            $size = 'small';
        }

        if ($size === 'thumb' && ($this->width <= self::small_thumb_size || $this->width <= self::small_thumb_size)) {
            $size = 'thumb-small';
        }

        return $size;
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
        if ($size === 'large' && $this->width <= self::medium_size && $this->width <= self::medium_size) {
            return false;
        }

        if ($size === 'medium' && $this->width <= self::small_size && $this->width <= self::small_size) {
            return false;
        }

        if ($size === 'thumb' && ($this->width <= self::small_thumb_size || $this->width <= self::small_thumb_size)) {
            return false;
        }

        return true;
    }

    /**
     * Generate full path to image directory
     *
     * If image id is 1009768, it will be stored in public/storage/image/1009/768
     *
     * @return string
     */
    public function getDirPath()
    {
        $path = 'storage/image/' . (int)($this->id/1000) . '/' . $this->id%1000;

        return public_path($path);
    }

    /**
     * Generate full path to image file
     *
     * If image id is 1009768, it will be stored in public/storage/image/1009/768 and contains:
     * - large.jpg
     * - medium.jpg
     * - small.jpg
     * - thumb.jpg
     * - thumb-small.jpg
     *
     * Even if the requested size doesn't exist, still return the expected path.
     *
     * @param string $size One of large, medium, small, thumb, thumb-small
     *
     * @return string
     */
    public function getFilePath($size = 'large')
    {
        if (!empty($this->external_url)) {
            return null;
        }

        $path = 'storage/image/' . (int)($this->id/1000) . '/' . $this->id%1000
                . '/' . $size . $this->getFileExtension();

        return public_path($path);
    }

    /**
     * Generate URL to image file
     *
     * If image id is 1009768, it will be stored in public/storage/image/1009/768 and contains:
     * - large.jpg
     * - medium.jpg
     * - small.jpg
     * - thumb.jpg
     * - thumb-small.jpg
     *
     * If the requested size doesn't exist, return a fallback size (smaller).
     *
     * @param string $size One of large, medium, small, thumb, thumb-small
     *
     * @return string
     */
    public function getUrl($size = 'large')
    {
        if (!empty($this->external_url)) {
            return $this->external_url;
        }

        $path = 'storage/image/' . (int)($this->id/1000) . '/' . $this->id%1000
                . '/' . $this->getFallbackSize($size) . $this->getFileExtension();

        return url($path);
    }

    /**
     * Generate URL to image thumbnail (300x300px)
     *
     * @return string
     */
    public function getThumbUrl()
    {
        return $this->getUrl('thumb');
    }

    /**
     * Generate URL to small image thumbnail (150x150px)
     *
     * @return string
     */
    public function getSmallThumbUrl()
    {
        return $this->getUrl('thumb-small');
    }

    /**
     * Save image file and generate sizes.
     *
     * @param Symfony\Component\HttpFoundation\File\File $file
     */
    public function saveFile(File $file)
    {
        $new_file = $file->move($this->getDirPath(), 'temp');
        $temp_file_path = $this->getDirPath() . '/temp';

        $image = new Imagick($temp_file_path);

        // Read original size. Before this, width and height properties are empty.
        $this->width = $image->getImageWidth();
        $this->height = $image->getImageHeight();

        $new_width = 0;
        $new_height = 0;

        if ($this->hasSize('large')) {
            $width = min(self::large_size, $this->width);
            $height = min(self::large_size, $this->height);

            $image->thumbnailImage($width, $height, true);
            $image->writeImage($this->getFilePath('large'));

            if ($new_width !== 0) {
                $new_width = $image->getImageWidth();
                $new_height = $image->getImageHeight();
            }
        }

        if ($this->hasSize('medium')) {
            $width = min(self::medium_size, $this->width);
            $height = min(self::medium_size, $this->height);

            $image->thumbnailImage($width, $height, true);
            $image->writeImage($this->getFilePath('medium'));

            if ($new_width !== 0) {
                $new_width = $image->getImageWidth();
                $new_height = $image->getImageHeight();
            }
        }

        if ($this->hasSize('small')) {
            $width = min(self::small_size, $this->width);
            $height = min(self::small_size, $this->height);

            $image->thumbnailImage($width, $height, true);
            $image->writeImage($this->getFilePath('small'));

            if ($new_width !== 0) {
                $new_width = $image->getImageWidth();
                $new_height = $image->getImageHeight();
            }
        }

        $image->readImage($temp_file_path);

        if ($this->hasSize('thumb')) {
            $size = min(self::thumb_size, $this->width, $this->height);

            $image->cropThumbnailImage($size, $size);
            $image->writeImage($this->getFilePath('thumb'));
        }

        if ($this->hasSize('thumb-small')) {
            $size = min(self::small_thumb_size, $this->width, $this->height);

            $image->cropThumbnailImage($size, $size);
            $image->writeImage($this->getFilePath('thumb-small'));
        }

        $image->destroy();

        unlink($temp_file_path);

        // Update resized width and height
        $this->width = $new_width;
        $this->height = $new_height;
        $this->save();
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
}
