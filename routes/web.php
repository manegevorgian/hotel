<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Auth::routes();

Route::resource('rooms', \App\Http\Controllers\RoomController::class)->except('show');
Route::resource('types', \App\Http\Controllers\TypeController::class);
Route::resource('booking', \App\Http\Controllers\BookingController::class)->except(['index', 'show','create', 'edit']);
Route::get('booking/create/{id}',[\App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
Route::post('rooms/filter',[\App\Http\Controllers\RoomController::class, 'filter']);
