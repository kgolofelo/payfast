<?php

use App\FilmShowTimes;
use Illuminate\Database\Seeder;

class FilmShowTimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $films = [1, 2, 3, 4];
        $films_times = ['14:00', '17:00', '20:00'];
        foreach ($films as $filmId){
            foreach ($films_times as $time) {
                FilmShowTimes::create([
                    'film_id' => $filmId,
                    'film_time' => $time,
                ]);
            }
        }
    }
}
