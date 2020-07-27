<?php

namespace App\Http\Controllers;

use App\MovieBooking;
use Illuminate\Http\Request;
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
                'number_of_seats' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            // Check how many seats are book per film, per show time
            $bookedSeats = MovieBooking::where(['film_id' => $request->film_id, 'film_show_time_id' => $request->film_show_time_id])->sum('number_of_seats');

            $newBookedSeats = $request->number_of_seats + $bookedSeats;
            $maxSeats = 30;
            if ($newBookedSeats > $maxSeats) {
                return response()->json(['message' => sprintf('Sorry, there are %s seats available.',  ($maxSeats - $bookedSeats))], 200);
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
}
