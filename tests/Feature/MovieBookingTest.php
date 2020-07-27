<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MovieBookingTest extends TestCase
{
    protected $token;

    public function testUserRegistration()
    {
        $response = $this->post('/api/register', [
            'name' => 'Movie User',
            'email' => 'KG' . rand(1, 1000) . '@demo.com',
            'role' => Config::get('auth.user_scopes.is_customer'),
            'password' => '12345',
            'password_confirmation' => '12345',
        ]);
        $response->assertStatus(200)->assertJsonStructure(['api_message', 'token']);

        $token = $response['token'];
        
        // Check if we can save a booking
        $response = $this->post('/api/save-booking', [
            'user_id' => '1',
            'film_id' => '1',
            'booking_reference' => rand(0, 9999),
            'film_show_time_id' => 1,
            'cinema_location_id' => 1,
            'number_of_seats' => 1,
        ],
            ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200)->assertJsonStructure(['booking_reference']);
    }

    public function testUserLogin()
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'pass321',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    // Check for atleast one cinema location
    public function testGettingCinemaLocations()
    {
        $response = $this->get('/api/cinema-locations');
        $response->assertStatus(200)->assertJsonStructure([0]);
    }

    // Check that a cinema is showing films
    public function testGettingFilms()
    {
        $response = $this->get('/api/films?cinema_location_id=1');
        $response->assertStatus(200)->assertJsonStructure([0]);
    }

    // Check that a film has show times
    public function testGettingFilmShowTimes()
    {
        $response = $this->get('/api/film-show-times?film_id=1');
        $response->assertStatus(200)->assertJsonStructure([0]);
    }
}
