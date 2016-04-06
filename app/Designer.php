<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designer';

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
     * @return DesignerTranslation
     */
    public function getTranslation($lang = 'en')
    {
        return DesignerTranslation::where([
            ['designer_id', $this->id],
            ['language', $lang],
        ])->first();
    }
}
