<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

        if ($size === 'thumb' && $this->width <= self::small_thumb_size && $this->width <= self::small_thumb_size) {
            $size = 'small-thumb';
        }

        return $size;
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
