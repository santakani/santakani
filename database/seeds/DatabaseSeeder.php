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
        $this->call(ArticleTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(PlaceTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(PlaceTagTableSeeder::class);
        $this->call(ArticleTagTableSeeder::class);
        $this->call(CountryImageTableSeeder::class);
        $this->call(CityImageTableSeeder::class);
        $this->call(PlaceImageTableSeeder::class);
        $this->call(ArticleImageTableSeeder::class);
    }
}
