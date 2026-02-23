<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\Supervisor\TripController as SupervisorTripController;
use App\Http\Controllers\Driver\TripController as DriverTripController;

Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('vehicles', AdminVehicleController::class);
    Route::get('trips', [AdminTripController::class, 'index'])->name('trips.index');
    Route::get('trips/{trip}', [AdminTripController::class, 'show'])->name('trips.show');
});

// Supervisor Routes
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('trips', [SupervisorTripController::class, 'index'])->name('trips.index');
    Route::get('trips/{trip}', [SupervisorTripController::class, 'show'])->name('trips.show');
    Route::post('trips/{trip}/approve', [SupervisorTripController::class, 'approve'])->name('trips.approve');
    Route::post('trips/{trip}/verify', [SupervisorTripController::class, 'verify'])->name('trips.verify');
});

// Driver Routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('trips', [DriverTripController::class, 'index'])->name('trips.index');
    Route::get('trips/create', [DriverTripController::class, 'create'])->name('trips.create');
    Route::post('trips', [DriverTripController::class, 'store'])->name('trips.store');
    Route::get('trips/{trip}', [DriverTripController::class, 'show'])->name('trips.show');
    Route::post('trips/{trip}/start', [DriverTripController::class, 'start'])->name('trips.start');
    Route::get('trips/{trip}/finish', [DriverTripController::class, 'finishForm'])->name('trips.finish');
    Route::post('trips/{trip}/finish', [DriverTripController::class, 'finish'])->name('trips.finish.submit');
});
