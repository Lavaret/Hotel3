<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/room/search', [RoomController::class, 'wyszukajPokoj'])->name('search.rooms');

Route::get('/room/result', [RoomController::class, 'pokazRezultat'])->name('result.rooms');

Route::post('/make/reservation', [ReservationController::class, 'zrobRezerwacje'])->name('make.reservation');

Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');

Route::post('/delete/reservation/{reservation}', [ReservationController::class, 'delete'])->name('delete.reservation');

require __DIR__.'/auth.php';
