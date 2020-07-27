<?php

use App\CinemaLocation;
use Illuminate\Database\Seeder;

class CinemaLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cinemaLocations = ['Muizenberg','Waterfront'];
        foreach ($cinemaLocations as $location) {
            CinemaLocation::create(['location_name' => $location]);
        }

    }
}
