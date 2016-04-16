<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * Get translations.
     *
     * @return CountryTranslation
     */
    public function getTranslation($lang = 'en')
    {
        return CountryTranslation::where([
            ['country_id', $this->id],
            ['locale', $lang],
        ])->first();
    }

    /**
     * Generate full URL to country page
     *
     * @return string
     */
    public function getUrl()
    {
        $path = 'country/' . $this->id;
        return url($path);
    }
}
