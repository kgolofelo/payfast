<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Film extends Controller
{
    /**
     *  This function is responsible for obtaining films that are linked to a theatre
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        $films = DB::table('film')
            ->join('theatre', 'film.theatre_id', '=', 'theatre.id')
            ->select('film.id', 'film.film_name')
            ->where('theatre.location_id', $request->cinema_location_id)
            ->get();
        return response()->json($films, 200);
    }
}
