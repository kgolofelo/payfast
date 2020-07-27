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
                'user_id' => 'required|integer',
                'film_id' => 'required|integer',
                'film_show_time_id' => 'required|integer',
                'cinema_location_id' => 'required|integer',
                'number_of_seats' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $data = $request->all();
            $data['booking_reference'] = rand(0, 9999);
            $data['booking_status'] = 'accepted';
            if (MovieBooking::Create($data)) {
                return response($data, 200);
            }
        } catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }
}
