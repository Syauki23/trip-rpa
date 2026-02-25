<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TripReportController as AdminTripReportController;
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
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('vehicles', AdminVehicleController::class);
    Route::resource('users', AdminUserController::class);
    Route::get('trips', [AdminTripController::class, 'index'])->name('trips.index');
    Route::get('trips/{trip}', [AdminTripController::class, 'show'])->name('trips.show');
    
    // Reports Routes
    Route::get('reports/trips', [AdminTripReportController::class, 'index'])->name('reports.trips');
    Route::get('reports/trips/export-excel', [AdminTripReportController::class, 'exportExcel'])->name('reports.trips.export-excel');
    Route::get('reports/trips/export-pdf', [AdminTripReportController::class, 'exportPdf'])->name('reports.trips.export-pdf');
});

// Supervisor Routes
// Supervisor Routes
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('dashboard', [SupervisorTripController::class, 'dashboard'])->name('dashboard');
    Route::get('trips', [SupervisorTripController::class, 'index'])->name('trips.index');
    Route::get('trips/pending', [SupervisorTripController::class, 'pending'])->name('trips.pending');
    Route::get('trips/all', [SupervisorTripController::class, 'all'])->name('trips.all');

    // HALAMAN REVIEW
    Route::get('trips/review', [SupervisorTripController::class, 'review'])->name('trips.review');

    // EXPORT EXCEL (INI YG PENTING!)
    Route::get('trips/review/export', [SupervisorTripController::class, 'exportReview'])
        ->name('trips.review.export');

    Route::get('trips/{trip}', [SupervisorTripController::class, 'show'])->name('trips.show');
    Route::post('trips/{trip}/approve', [SupervisorTripController::class, 'approve'])->name('trips.approve');
    Route::post('trips/{trip}/verify', [SupervisorTripController::class, 'verify'])->name('trips.verify');
});

// Driver Routes
Route::middleware(['auth', 'role:driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('trips', [DriverTripController::class, 'index'])->name('trips.index');
    Route::get('trips/create', [DriverTripController::class, 'create'])->name('trips.create');
    Route::post('trips', [DriverTripController::class, 'store'])->name('trips.store');
    Route::get('trips/history', [DriverTripController::class, 'history'])->name('trips.history');
    Route::get('trips/{trip}', [DriverTripController::class, 'show'])->name('trips.show');
    Route::post('trips/{trip}/start', [DriverTripController::class, 'start'])->name('trips.start');
    Route::get('trips/{trip}/finish', [DriverTripController::class, 'finishForm'])->name('trips.finish');
    Route::post('trips/{trip}/finish', [DriverTripController::class, 'finish'])->name('trips.finish.submit');
});
