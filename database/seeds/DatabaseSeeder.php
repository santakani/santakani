<?php

/*
 * This file is part of Santakani
 *
 * (c) Guo Yunhe <guoyunhebrave@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 *
 * Root seeder that loads all seeders.
 *
 * @author Guo Yunhe <guoyunhebrave@gmail.com>
 * @see https://github.com/santakani/santakani.com/wiki/Test-Data
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);

        $this->call(TagTableSeeder::class);

        $this->call(CountryTableSeeder::class);
        $this->call(CityTableSeeder::class);

        $this->call(DesignerTableSeeder::class);
        $this->call(PlaceTableSeeder::class);
        $this->call(StoryTableSeeder::class);
        $this->call(DesignTableSeeder::class);
    }
}
