<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MovieBookingTest extends TestCase
{
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
    }

    public function testUserLogin()
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@admin.com',
            'password' => 'pass321',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }
}
