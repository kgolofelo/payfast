<?php

namespace App\Http\Controllers;

use App\CinemaLocation;
use Illuminate\Http\Request;

class CinemaLocations extends Controller
{
    public function index() {
        return response()->json(CinemaLocation::all(['id','location_name']),200);
    }
}
