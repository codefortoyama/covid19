<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/opendata', function () {
    return view('top');
});
Route::get('/opendata/get_patients', 'OpendataController@get_patients');
Route::get('/opendata/get_inspected', 'ToyamaCountsController@get_inspected');
Route::get('/opendata/get_confirm_negative', 'ConfirmNegativeController@get_confirm_negative');
Route::get('/opendata/get_call_center', 'CallCenterController@get_call_center');
