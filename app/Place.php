<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'place';

    /**
     * Generate URL to avatar file
     *
     * @return Image
     */
    public function getImage()
    {
        return Image::find($this->image_id);
    }

    /**
     * Generate URL to image file
     *
     * @return PlaceTranslation
     */
    public function getTranslation($lang = 'en')
    {
        return PlaceTranslation::where([
            ['place_id', $this->id],
            ['locale', $lang],
        ])->first();
    }
}
