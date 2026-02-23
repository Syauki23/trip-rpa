<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
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
