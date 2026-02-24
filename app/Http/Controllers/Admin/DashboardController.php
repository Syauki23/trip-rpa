<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Total kendaraan
        $totalVehicles = Vehicle::count();
        
        // Total perjalanan
        $totalTrips = Trip::count();
        
        // Total perjalanan selesai (status = completed)
        $completedTrips = Trip::where('status', 'completed')->count();
        
        // Total perjalanan menunggu approval (status = pending)
        $pendingTrips = Trip::where('status', 'pending')->count();
        
        // Total user (driver + supervisor + admin)
        $totalUsers = User::count();
        
        return view('admin.dashboard', compact(
            'totalVehicles',
            'totalTrips',
            'completedTrips',
            'pendingTrips',
            'totalUsers'
        ));
    }
}
