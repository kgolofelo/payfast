<?php

namespace App\Http\Controllers;

use App\MovieBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Booking extends Controller
{
    /**
     *  This function saves seat-booking details
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'film_id' => 'required|integer|min:1',
                'film_show_time_id' => 'required|integer|min:1',
                'cinema_location_id' => 'required|integer|min:1',
                'number_of_seats' => 'required|integer|min:1',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            // Check how many seats are booked per film, per show time
            $bookedSeats = MovieBooking::where(['film_id' => $request->film_id, 'film_show_time_id' => $request->film_show_time_id])->sum('number_of_seats');

            $newBookedSeats = $request->number_of_seats + $bookedSeats;
            $maxSeats = 30;
            if ($newBookedSeats > $maxSeats) {
                return response()->json(['message' => sprintf('Sorry, there are %s seats available.', ($maxSeats - $bookedSeats))], 200);
            }

            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            $data['booking_reference'] = rand(0, 9999);
            $data['booking_status'] = 'accepted';
            if (MovieBooking::Create($data)) {
                $data['message'] = sprintf('Booking reference: %s', $data['booking_reference']);
                return response($data, 200);
            }
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * This function returns a user's booking history - Cinema, Film, Show Time, Date, Number of seats, Booking status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $bookingHistory = DB::table('movie_booking')
            ->join('film', 'movie_booking.film_id', '=', 'film.id')
            ->join('cinema_locations', 'movie_booking.cinema_location_id', '=', 'cinema_locations.id')
            ->join('film_show_times', 'movie_booking.film_show_time_id', '=', 'film_show_times.id')
            ->select('cinema_locations.location_name', 'film.film_name', 'movie_booking.booking_reference', 'film_show_times.film_time',
                'movie_booking.created_at', 'movie_booking.number_of_seats', 'movie_booking.booking_status')
            ->where('movie_booking.user_id', $request->user()->id)
            ->get();
        return response()->json($bookingHistory, 200);
    }

    /**
     *  This function sets a movie booking's status to cancelled, if the movie
     *  gets cancelled within 1 hour of its show time.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_reference' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $booking = MovieBooking::where('booking_reference', $request->booking_reference)
                ->join('film_show_times', 'movie_booking.film_show_time_id', '=', 'film_show_times.id')
                ->select('film_show_times.film_time', 'movie_booking.id')
                ->first();

            if (!empty($booking)) {
                $bookingTime = $booking->toArray();
                $bookingDateTime = Carbon::parse($bookingTime['film_time'], Config::get('app.timezone'));
                $currentDateTime = Carbon::now(Config::get('app.timezone'));
                $hourDifference = $currentDateTime->diffInHours($bookingDateTime);

                if ($bookingDateTime > $currentDateTime && $hourDifference > 1) {
                    $booking->booking_status = 'cancelled';
                    $booking->save();
                    return response()->json(['message' => 'Booking cancelled successfully.'], 200);
                }
                return response()->json(['message' => 'Could not cancel booking.'], 200);
            }
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }
}
