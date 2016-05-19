<?php

namespace App;

class Tag extends Translatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * Get translations.
     *
     * @return TagTranslation
     */
    public function getTranslation($lang = 'en')
    {
        return TagTranslation::where([
            ['tag_id', $this->id],
            ['locale', $lang],
        ])->first();
    }

    /**
     * Generate full URL to tag page
     *
     * @return string
     */
    public function getUrl()
    {
        $path = 'tag/' . $this->id;
        return url($path);
    }
}
