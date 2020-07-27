<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieBooking extends Model
{
    protected $table='movie_booking';
    protected $fillable = [
        'user_id',
        'film_id',
        'booking_reference',
        'film_show_time_id',
        'cinema_location_id',
        'number_of_seats',
        'booking_status'
    ];
}
