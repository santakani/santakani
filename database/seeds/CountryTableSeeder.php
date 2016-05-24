<?php

/*
 * This file is part of santakani.com
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * CountryTableSeeder
 *
 * Fill test data into "country" and "country_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Country
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            // code => image_id
            'FI' => 24,
            'CN' => 25,
            'DE' => 26,
            'JP' => 27,
        ];

        foreach ($countries as $code => $image_id) {
            DB::table('country')->where('code', $code)->update([
                'image_id' => $image_id,
            ]);
        }
    }
}
