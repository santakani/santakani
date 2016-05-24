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
 * DesignerTableSeeder
 *
 * Fill test data into "designer" and "designer_translation" table.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Designer
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class DesignerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designers = [
            1 => [1, 1, 8, 1, 'Costo'],
            2 => [1, 1, 13, 1, 'Tanja Kurittu'],
            3 => [1, 1, 8, 1, 'Costo'],
            4 => [1, 1, 13, 1, 'Tanja Kurittu'],
            5 => [1, 1, 8, 1, 'Costo'],
            6 => [1, 1, 13, 1, 'Tanja Kurittu'],
        ];

        $timestamp = Carbon::now()->format('Y-m-d H:i:s');

        foreach ($designers as $id => $designer) {
            DB::table('designer')->insert([
                'country_id' => $designer[0],
                'city_id' => $designer[1],
                'image_id' => $designer[2],
                'user_id' => $designer[3],
                'email' => 'contact@example.com',
                'website' => 'http://www.example.com/',
                'facebook' => 'https://www.facebook.com/',
                'twitter' => 'https://twitter.com/',
                'google_plus' => 'https://plus.google.com/',
                'instagram' => 'https://www.instagram.com/',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            DB::table('designer_translation')->insert([
                'designer_id' => $id,
                'locale' => 'en',
                'name' => $designer[4],
                'tagline' => 'Good typeface make any text easier to read',
                'content' => file_get_contents('http://loripsum.net/api'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

    }
}
