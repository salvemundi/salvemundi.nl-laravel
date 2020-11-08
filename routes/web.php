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

use App\Http\Controllers\HomeController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/signin', [App\Http\Controllers\AuthController::class, 'signin']);
Route::get('/callback', [App\Http\Controllers\AuthController::class, 'callback']);
Route::get('/signout', [App\Http\Controllers\AuthController::class, 'signout']);