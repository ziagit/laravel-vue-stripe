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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("charge","App\Http\Controllers\ChargeController@charge");
Route::post("customer/create","App\Http\Controllers\ChargeController@createCustomer");
Route::post("customer/charge","App\Http\Controllers\ChargeController@chargeCustomer");
Route::get("charge/refund","App\Http\Controllers\ChargeController@refundCharge");
