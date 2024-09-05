<?php

use App\Http\Controllers\web\WebViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WebViewController::class, 'index'])->name('home');
Route::get('search', [WebViewController::class, 'search']);
Route::get('property_details/{id}', [WebViewController::class, 'property_details']);
Route::get('payment/{hotel_id}/{room_id}', [WebViewController::class, 'payNow']);
Route::post('book-now', [WebViewController::class, 'bookNow']);
Route::get('booking-status/{booking_id}', [WebViewController::class, 'bookingStatus']);
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return "Cache is cleared";
});