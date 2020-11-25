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

Route::post('link/store', 'App\Http\Controllers\LinkController@store');
Route::get('link/get', 'App\Http\Controllers\LinkController@get');
Route::get('movies/get', 'App\Http\Controllers\MovieController@get');
Route::get('movies/search', 'App\Http\Controllers\MovieController@search');
Route::get('movies/get/single', 'App\Http\Controllers\MovieController@getSingle');
