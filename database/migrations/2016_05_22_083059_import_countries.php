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

        $json_string = file_get_contents(base_path('vendor/mledoze/countries/dist/countries.json'));

        $country_list = json_decode($json_string, true);

        $json_string = null;

        echo "import countries start\n";

        foreach ($country_list as $country) {

            if (empty($country['latlng']) || empty($country['region'])) {
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

            self::insertTranslation($id, 'en', $country['name']['common']);

            foreach ($country['name']['native'] as $lang_code3 => $name) {
                if ($lang_code3 === 'cmn' || $lang_code3 === 'zho') {
                    $lang_code1 = 'zh';
                } else {
                    $lang_code1 = $languages->findByCode3($lang_code3)->code1();
                }
                self::insertTranslation($id, $lang_code1, $name['common']);
            }

            foreach ($country['translations'] as $lang_code3 => $name) {
                if ($lang_code3 === 'cmn' || $lang_code3 === 'zho') {
                    $lang_code1 = 'zh';
                } else {
                    $lang_code1 = $languages->findByCode3($lang_code3)->code1();
                }
                self::insertTranslation($id, $lang_code1, $name['common']);
            }
        }

        echo "import countries done\n";
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

    static function insertTranslation($id, $locale, $name) {
        if ( count( DB::table('country_translation')->where([
            ['country_id', $id],
            ['locale', $locale],
        ])->first() ) ) {
            return;
        }

        if (empty($locale)) {
            echo "skip\n";
            return;
        } else {
            echo $id . "\t" . $locale . "\t" . $name . "\n";
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
