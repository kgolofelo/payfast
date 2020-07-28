<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::apiResources([
    'cinema-locations' => 'CinemaLocations',
    'films' => 'Film',
    'film-show-times' => 'FilmShowTimes',
]);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api','scope:'.Config::get('auth.user_scopes.is_customer')]], function(){
    Route::post('save-booking', 'Booking@store');
    Route::put('booking-cancel', 'Booking@update');
    Route::get('booking-history', 'Booking@index');
});
