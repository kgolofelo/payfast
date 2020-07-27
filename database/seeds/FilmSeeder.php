<?php
use App\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $films = [1 => 'Matrix', 2 => 'Passenger 57', 3 => 'John Wick', 4 => 'Spider Man'];
        foreach ($films as $theatre_id=>$film) {
            Film::create([
                'film_name' => $film,
                'theatre_id' => $theatre_id,
            ]);
        }
    }
}
