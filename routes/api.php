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

Route::middleware('samu-api.auth')->get('/participants', [App\Http\Controllers\IntroController::class, 'GetParticipants']);
Route::middleware('client_credentials')->post('/coupons',[App\Http\Controllers\CouponController::class,'apiStore']);
Route::middleware('client_credentials')->post('/members',[App\Http\Controllers\AzureController::class,'createAzureUserAPI']);
