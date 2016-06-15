<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

use Carbon\Carbon;

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
        $handle = fopen(base_path("database/sources/countryInfo.txt"), "r");

        if ($handle) {
            while (($country = fgetcsv($handle, 0, "\t")) !== false) {

                if (!$this->filter($country)) {
                    continue;
                }

                $id = DB::table('country')->insertGetId([
                    'code' => $country[0],
                    'continent' => $country[8],
                    'currency' => $country[10],
                    'geoname_id' => $country[16],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                DB::table('country_translation')->insert([
                    'country_id' => $id,
                    'locale' => 'en',
                    'name' => $country[4],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

            }

            fclose($handle);
        }
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
     * Filter countries. true: imported. false: ignored.
     *
     * @param array $country
     * @return boolean
     */
    public function filter($country)
    {
        if (App::environment('local')) {
            // local: only import Europe countries.
            return $country[8] === 'EU';
        } else {
            // test, production: import all countries.
            return !empty($country[0]) && !empty($country[4]) && !empty($country[8]);
        }
    }
}
