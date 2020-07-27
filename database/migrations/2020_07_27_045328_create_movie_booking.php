<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_booking', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('film_id');
            $table->string('booking_reference');
            $table->integer('film_show_time_id');
            $table->integer('cinema_location_id');
            $table->integer('number_of_seats');
            $table->integer('booking_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_booking');
    }
}
