<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Gmo\Iso639\Languages;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * ImportCountries
 *
 * Database migration to import country data from countries.json.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Country
 */
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

            $id = DB::table('country')->insertGetId([
                'slug' => $slugify->slugify($country['name']['common']),
                'code' => $country['cca2'],
                'region' => $country['region'],
                'subregion' => $country['subregion'],
                'coordinate' => DB::raw($coordinate),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

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

    /**
     * Insert translation to country_translation table.
     *
     * @param int $id Country ID
     * @param string $locale Language code
     * @param string $name Translation of name
     */
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
