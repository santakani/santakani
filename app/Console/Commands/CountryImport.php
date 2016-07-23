<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Country;

class CountryImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:import {country? : ID of the country} {--all : import all countries}';

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
            foreach(Country::all() as $country) {
                $country->import();
                sleep(5);
            }
        } elseif ($this->argument('country')) {
            $country = Country::find($this->argument('country'));
            if (count($country)) {
                $country->import();
            }
        }
    }
}
