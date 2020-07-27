<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             UsersTableSeeder::class,
             CinemaLocationsSeeder::class,
             FilmSeeder::class,
             FilmShowTimesSeeder::class,
             TheatreSeeder::class
         ]);
    }
}
