<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.trips.index', compact('trips'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['driver', 'vehicle']);
        return view('admin.trips.show', compact('trip'));
    }
}
