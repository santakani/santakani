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
        return $this->getUrl('thumb');
    }
}
