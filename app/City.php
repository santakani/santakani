<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Localization\Languages;

class City extends Model
{
    use SoftDeletes;

    use EditLock;
    use ImageFeature;
    use LikeFeature;
    use TranslateFeature;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'locked_at'];

    /**
     * Attributes that will be appeded to Array or JSON output.
     *
     * @var array
     */
    protected $appends = [
        'url', 'name', 'full_name', 'native_name', 'native_full_name',
        'english_name', 'english_full_name', 'search_index'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                          Relationship Methods                          //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Cover image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }



    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    //                           Dynamic Properties                           //
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////


    /**
     * "url" getter.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('city/' . $this->id);
    }

    /**
     * "name" getter.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->text('name');
    }

    /**
     * "country_name" getter.
     *
     * @return string
     */
    public function getCountryNameAttribute()
    {
        return $this->country->text('name');
    }

    /**
     * "full_name" getter. Like "Helsinki, Finland"
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->text('name') . ', ' . $this->country->text('name');
    }

    // TODO use country native language
    public function getNativeNameAttribute()
    {
        return $this->text('name', 'en');
    }

    public function getNativeFullNameAttribute()
    {
        return $this->text('name', 'en') . ', ' . $this->country->text('name', 'en');
    }

    public function getEnglishNameAttribute()
    {
        return $this->text('name', 'en');
    }

    public function getEnglishFullNameAttribute()
    {
        return $this->text('name', 'en') . ', ' . $this->country->text('name', 'en');
    }

    /**
     * "search_index" getter.
     *
     * @return string
     */
    public function getSearchIndexAttribute()
    {
        $search_index = '';
        foreach ($this->translations as $translation) {
            $search_index .= $translation->name;
        }
        return $search_index;
    }


    //====================================
    // Other methods
    //====================================

    /**
     * Import data from geonames.org
     */
    public function import()
    {
        $username = env('GEONAMES_USERNAME', 'demo');
        $json = file_get_contents("http://api.geonames.org/getJSON?geonameId={$this->geoname_id}&username={$username}");

        $data = json_decode($json);

        $names = [];

        foreach ($data->alternateNames as $name_pair) {
            if (isset($name_pair->lang) && Languages::has($name_pair->lang)) {
                if (!empty($name_pair->isPreferredName) || empty($names[$name_pair->lang])) {
                    $names[$name_pair->lang] = $name_pair->name;
                }
            }
        }

        foreach ($names as $locale => $name) {
            $translation = CityTranslation::firstOrNew([
                'city_id' => $this->id,
                'locale' => $locale,
            ]);

            $translation->name = $name;

            $translation->save();
        }

        $this->imported_at = Carbon::now()->format('Y-m-d H:i:s');
    }

}
