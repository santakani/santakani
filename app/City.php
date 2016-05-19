<?php

namespace App;

class City extends Translatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city';

    /**
     * Get translations.
     *
     * @return CityTranslation
     */
    public function getTranslation($lang = 'en')
    {
        return CityTranslation::where([
            ['city_id', $this->id],
            ['locale', $lang],
        ])->first();
    }

    /**
     * Generate full URL to city page
     *
     * @return string
     */
    public function getUrl()
    {
        $path = 'city/' . $this->id;
        return url($path);
    }
}
