<?php

use Illuminate\Database\Seeder;

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
        $this->call(UserRoleTableSeeder::class);
        $this->call(ImageTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(TaggableTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(PlaceTableSeeder::class);
        $this->call(DesignerTableSeeder::class);
    }
}
