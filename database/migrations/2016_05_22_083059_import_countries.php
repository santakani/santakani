<?php

use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Gmo\Iso639\Languages;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImportCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $slugify = new Slugify();
        $languages = new Languages();

        $json_string = file_get_contents(base_path('database/sources/countries.json'));

        $country_list = json_decode($json_string, true);

        $json_string = null;

        echo "Import countries start\n";

        foreach ($country_list as $country) {

            if (!$this->filter($country)) {
                continue;
            }

            $x = $country['latlng'][0];
            $y = $country['latlng'][1];
            $coordinate = "PointFromText('POINT($x $y)')";

            DB::table('country')->insert([
                'slug' => $slugify->slugify($country['name']['common']),
                'code' => $country['cca2'],
                'region' => $country['region'],
                'subregion' => $country['subregion'],
                'coordinate' => DB::raw($coordinate),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            $id = DB::table('country')->where('code', $country['cca2'])->first()->id;

            $this->insertTranslation($id, 'en', $country['name']['common']);

            foreach ($country['name']['native'] as $lang_code3 => $name) {
                if ($lang_code3 === 'cmn' || $lang_code3 === 'zho') {
                    $lang_code1 = 'zh';
                } else {
                    $lang_code1 = $languages->findByCode3($lang_code3)->code1();
                }
                $this->insertTranslation($id, $lang_code1, $name['common']);
            }

            foreach ($country['translations'] as $lang_code3 => $name) {
                if ($lang_code3 === 'cmn' || $lang_code3 === 'zho') {
                    $lang_code1 = 'zh';
                } else {
                    $lang_code1 = $languages->findByCode3($lang_code3)->code1();
                }
                $this->insertTranslation($id, $lang_code1, $name['common']);
            }
        }

        echo "Import countries done\n";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Cannot undo
    }


    /**
     * These areas will be ignored.
     *
     * @param array $country
     * @return boolean
     */
    public function filter($country)
    {
        $white_list = [

        ];

        if (in_array($country['cca2'], $white_list)) {
            return true;
        }

        if (empty($country['latlng'])) {
            echo "\tSkip: " . $country['name']['common'] . "\n";
            return false;
        }

        $black_list = [
            'AQ'
        ];

        if (in_array($country['cca2'], $black_list)) {
            echo "\tSkip: " . $country['name']['common'] . "\n";
            return false;
        }

        return true;
    }

    public function insertTranslation($id, $locale, $name)
    {
        if (empty($id) || empty($locale) || empty($name)) {
            return;
        }

        if ( count( DB::table('country_translation')->where([
            ['country_id', $id],
            ['locale', $locale],
        ])->first() ) ) {
            return;
        }

        DB::table('country_translation')->insert([
            'country_id' => $id,
            'locale' => $locale,
            'name' => $name,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
