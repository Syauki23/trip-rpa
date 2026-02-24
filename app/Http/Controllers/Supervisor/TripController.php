<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function dashboard()
    {
        // Total trip pending
        $totalPending = Trip::where('status', 'pending')->count();
        
        // Total trip on trip (ongoing)
        $totalOnTrip = Trip::where('status', 'ongoing')->count();
        
        // Total trip selesai
        $totalCompleted = Trip::where('status', 'completed')->count();
        
        // 5 pengajuan terbaru
        $recentSubmissions = Trip::with(['driver', 'vehicle'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // 5 perjalanan selesai terbaru
        $recentCompleted = Trip::with(['driver', 'vehicle'])
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('supervisor.dashboard', compact(
            'totalPending',
            'totalOnTrip',
            'totalCompleted',
            'recentSubmissions',
            'recentCompleted'
        ));
    }
    
    public function pending()
    {
        $trips = Trip::with(['driver', 'vehicle'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('supervisor.trips.pending', compact('trips'));
    }
    
    public function all()
    {
        $trips = Trip::with(['driver', 'vehicle'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('supervisor.trips.all', compact('trips'));
    }
    
    public function review()
    {
        $trips = Trip::with(['driver', 'vehicle'])
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        return view('supervisor.trips.review', compact('trips'));
    }

    public function index()
    {
        $trips = Trip::with(['driver', 'vehicle'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('supervisor.trips.index', compact('trips'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['driver', 'vehicle']);
        return view('supervisor.trips.show', compact('trip'));
    }

    public function approve(Trip $trip)
    {
        if ($trip->status !== 'pending') {
            return back()->with('error', 'Only pending trips can be approved.');
        }

        $trip->update(['status' => 'approved']);

        return back()->with('success', 'Trip approved successfully.');
    }

    public function verify(Trip $trip)
    {
        if ($trip->status !== 'completed') {
            return back()->with('error', 'Only completed trips can be verified.');
        }

        $trip->update(['status' => 'verified']);

        return back()->with('success', 'Trip verified successfully.');
    }
}
