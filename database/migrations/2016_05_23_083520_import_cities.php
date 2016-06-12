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
 * ImportCities
 *
 * Database migration to import city data from cities15000.txt.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/City
 */
class ImportCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $handle = fopen(base_path("database/sources/cities15000.txt"), "r");
        if ($handle) {
            while (($city = fgetcsv($handle, 0, "\t")) !== false) {

                if (!$this->filter($city)) {
                    continue;
                }

                $country = DB::table('country')->where('code', $city[8])->first();

                if (empty($country)) {
                    continue;
                }

                $id = DB::table('city')->insertGetId([
                    'country_id' => $country->id,
                    'latitude' => $city[4],
                    'longitude' => $city[5],
                    'timezone' => $city[17],
                    'geoname_id' => $city[0],
                    'imported_at' => Carbon::now()->subDays(30)->format('Y-m-d'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                DB::table('city_translation')->insert([
                    'city_id' => $id,
                    'locale' => 'en',
                    'name' => $city[1],
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
     * Filter cities. true: imported. false: ignored.
     *
     * @param array $city
     * @return boolean
     */
    public function filter($city)
    {
        if (App::environment('local')) {
            // local: only import Finland cities.
            return $city[8] === 'FI';
        } else {
            // test, production: import all cities.
            return count($city) === 19;
        }
    }
}
