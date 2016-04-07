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
        $this->call(ImageTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(PlaceTableSeeder::class);
        $this->call(PlaceTagTableSeeder::class);
        $this->call(PlaceImageTableSeeder::class);
        $this->call(DesignerTableSeeder::class);
        $this->call(DesignerTagTableSeeder::class);
        $this->call(DesignerImageTableSeeder::class);
    }
}
