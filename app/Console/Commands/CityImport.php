<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\City;

class CityImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'city:import {city? : ID of the city} {--all : import all cities}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import geo data from geonames.org';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('all')) {
            foreach(City::all() as $city) {
                $city->import();
                sleep(5);
            }
        } elseif ($this->argument('city')) {
            $city = City::find($this->argument('city'));
            if (count($city)) {
                $city->import();
            }
        }
    }
}
