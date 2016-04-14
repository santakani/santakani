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
     * Maximum size of images. Uploaded images larger than this value will be scaled.
     *
     * @var int
     */
    protected $max_size = 1200;

    /**
     * Size of image thumbnails. Uploaded images smaller than this value will not
     * generate thumbnail file, using full image instead.
     *
     * @var int
     */
    protected $thumb_size = 600;

    /**
     * Generate URL to image file
     *
     * @return string
     */
    public function getUrl($size = 'full')
    {
        return '/storage/image/' . (int)($this->id/1000) . '/' . $this->id%1000
            . '/' . $size . '.' . $this->format;
    }

    /**
     * Generate URL to image thumbnail file
     *
     * @return string
     */
    public function getThumbUrl($size = 'thumb')
    {
        if ($this->width <= $this->thumb_size && $this->height <= $this->thumb_size) {
            return $this->getUrl('full');
        } else {
            return $this->getUrl('thumb');
        }
    }
}
