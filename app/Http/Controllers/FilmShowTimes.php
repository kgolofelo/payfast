<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmShowTimes extends Controller
{
    public function index(Request $request) {
        $showTimes = \App\FilmShowTimes::where('film_id', $request->film_id)->get(['id','film_time']);
        return response()->json($showTimes, 200);
    }
}
