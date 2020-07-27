<?php

use App\Theatre;
use Illuminate\Database\Seeder;

class TheatreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theatres = ['Theatre One' => 1, 'Theatre Two' => 1, 'Theatre Three' => 2, 'Theatre Four' => 2];
        foreach ($theatres as $theatre=>$locationId) {
            Theatre::create([
                'name' => $theatre,
                'location_id' => $locationId,
                'max_seats' => 30,
            ]);
        }
    }
}
