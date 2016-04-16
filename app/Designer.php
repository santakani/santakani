<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Designer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'designer';

    /**
     * Get the main image, it is designer photo or brand logo.
     *
     * @return Image
     */
    public function getMainImage()
    {
        return Image::find($this->image_id);
    }

    /**
     * Get other images, they are usually photos of design.
     *
     * @return Image
     */
    public function getImages()
    {
        $images = [];

        $image_ids = DB::table('designer_image')->select('image_id as id', 'order')
            ->where('designer_id', $this->id)->get();

        foreach ($image_ids as $image_id) {
            $images[$image_id->order] = Image::find($image_id->id);
        }
        return $images;
    }

    /**
     * Get tags that the designer is related to.
     *
     * @return Tag
     */
    public function getTags()
    {
        $tags = [];

        $tag_ids = DB::table('designer_tag')->select('tag_id')
            ->where('designer_id', $this->id)->get();

        foreach ($tag_ids as $key => $tag_id) {
            $tags[] = Tag::find($tag_id->tag_id);
        }

        return $tags;
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
