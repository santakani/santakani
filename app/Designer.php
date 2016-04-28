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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'city_id', 'image_id', 'user_id', 'email', 'website', 'facebook',
        'twitter', 'google_plus', 'instagram'
    ];

    /**
     * The attributes that are managed by accessor and mutator functions.
     * See https://laravel.com/docs/5.2/eloquent-mutators
     *
     * @var array
     */
    protected $appends = [
        'country', 'country_name', 'city', 'city_name', 'image', 'images',
        'tags', 'tag_ids', 'translations', 'name', 'tagline', 'content', 'url'
    ];

    /**
     * Get country that the designer is located. Used to auto-generate attribute country.
     *
     * @return Country
     */
    public function getCountryAttribute()
    {
        return Country::find($this->country_id);
    }

    /**
     * Get country name of default translation. Used to auto-generate attribute country_name.
     *
     * @return string
     */
    public function getCountryNameAttribute()
    {
        if ($country = $this->getCountryAttribute()) {
            if ($translation = $country->getTranslation()) {
                return $translation->name;
            }
        }
    }

    /**
     * Get city that the designer is located. Used to auto-generate attribute city.
     *
     * @return City
     */
    public function getCityAttribute()
    {
        return City::find($this->city_id);
    }

    /**
     * Get city name of default translation. Used to auto-generate attribute city_name.
     *
     * @return string
     */
    public function getCityNameAttribute()
    {
        if ($city = $this->getCityAttribute()) {
            if ($translation = $city->getTranslation()) {
                return $translation->name;
            }
        }
    }

    /**
     * Get the main image, used for page banner and thumbnail. Used to auto-generate
     * attribute main_image.
     *
     * @return Image
     */
    public function getImageAttribute()
    {
        return Image::find($this->image_id);
    }

    /**
     * Get other images, they are usually photos of design. Used to auto-generate
     * attribute images.
     *
     * @return Image[]
     */
    public function getImagesAttribute()
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
     * Get tags that the designer is related to. Used to auto-generate attribute tags.
     *
     * @return Tag
     */
    public function getTagsAttribute()
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
     * Get tags that the designer is related to. Used to auto-generate attribute tag_ids.
     *
     * @return int[]
     */
    public function getTagIdsAttribute()
    {
        $tags = [];

        $tag_ids = DB::table('designer_tag')->select('tag_id')
            ->where('designer_id', $this->id)->get();

        foreach ($tag_ids as $key => $tag_id) {
            $tags[] = $tag_id->tag_id;
        }

        return $tags;
    }

    /**
     * Get translations. Used to auto-generate attribute translation.
     *
     * @return DesignerTranslation[]
     */
    public function getTranslationsAttribute($lang = 'en')
    {
        return DesignerTranslation::where([
            ['designer_id', $this->id],
            ['locale', $lang],
        ])->get();
    }

    /**
     * Get translated texts. Used to auto-generate attribute translation.
     *
     * @return DesignerTranslation
     */
    public function text($name, $locale = 'en')
    {
        return DesignerTranslation::where([
            ['designer_id', $this->id],
            ['locale', $locale],
        ])->first()[$name];
    }

    /**
     * Name of default translation. Used to auto-generate attribute name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->text('name');
    }

    /**
     * Tagline of default translation. Used to auto-generate attribute tagline.
     *
     * @return string
     */
    public function getTaglineAttribute()
    {
        return $this->text('tagline');
    }

    /**
     * Content of default translation. Used to auto-generate attribute content.
     *
     * @return string
     */
    public function getContentAttribute()
    {
        return $this->text('content');
    }

    /**
     * URL of designer page. Used to auto-generate attribute url.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('designer/' . $this->id);
    }
}
