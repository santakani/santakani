<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use App\Localization\Languages;

class Country extends Model
{
    use Features\EditLockFeature;
    use Features\ImageFeature;
    use Features\LikeFeature;
    use Features\TranslationFeature;
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country';

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
        'url', 'name', 'search_index'
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
        return url('country/' . $this->id);
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

    public function getContinentNameAttribute()
    {
        switch ($this->continent) {
            case 'AS': return trans('geo.asia');
            case 'AF': return trans('geo.africa');
            case 'EU': return trans('geo.europe');
            case 'NA': return trans('geo.north_america');
            case 'SA': return trans('geo.south_america');
            case 'OC':
            case 'AU': return trans('geo.oceania');
        }
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
            $translation = CountryTranslation::firstOrNew([
                'country_id' => $this->id,
                'locale' => $locale,
            ]);

            $translation->name = $name;

            $translation->save();
        }

        $this->imported_at = Carbon::now()->format('Y-m-d H:i:s');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        // Load relationships
        $this->load('translations');

        // Generate array data
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
}
