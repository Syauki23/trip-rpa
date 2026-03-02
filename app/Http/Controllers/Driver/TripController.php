<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::where('driver_id', auth()->id())
            ->with('vehicle')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('driver.trips.index', compact('trips'));
    }

    public function history()
    {
        $trips = Trip::where('driver_id', auth()->id())
            ->whereIn('status', ['completed', 'rejected'])
            ->with('vehicle')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('driver.trips.history', compact('trips'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'available')->get();
        return view('driver.trips.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'km_awal' => 'required|integer|min:0',
            'foto_awal' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tujuan' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'petugas_1' => 'required|string|max:255',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required|date_format:H:i',
        ]);

        $fotoAwalPath = $request->file('foto_awal')->store('trips', 'public');

        // Gabungkan tanggal dan jam menjadi datetime
        $jamOut = $validated['tanggal_berangkat'] . ' ' . $validated['jam_berangkat'];

        Trip::create([
            'driver_id' => auth()->id(),
            'vehicle_id' => $validated['vehicle_id'],
            'km_awal' => $validated['km_awal'],
            'foto_awal' => $fotoAwalPath,
            'tujuan' => $validated['tujuan'],
            'keperluan' => $validated['keperluan'],
            'petugas_1' => $validated['petugas_1'],
            'jam_out' => $jamOut,
            'status' => 'ongoing',
        ]);

        // Set vehicle status to in_use
        $vehicle = \App\Models\Vehicle::find($validated['vehicle_id']);
        if ($vehicle) {
            $vehicle->update(['status' => 'in_use']);
        }

        return redirect()->route('driver.trips.index')
            ->with('success', 'Trip created successfully and started.');
    }

    public function show(Trip $trip)
    {
        if ($trip->driver_id !== auth()->id()) {
            abort(403);
        }

        return view('driver.trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        if ($trip->driver_id !== auth()->id()) {
            abort(403);
        }

        // Only allow editing ongoing trips
        if ($trip->status !== 'ongoing') {
            return redirect()->route('driver.trips.show', $trip)
                ->with('error', 'Only ongoing trips can be edited.');
        }

        $vehicles = Vehicle::where('status', 'available')
            ->orWhere('id', $trip->vehicle_id)
            ->get();
        
        return view('driver.trips.edit', compact('trip', 'vehicles'));
    }

    public function update(Request $request, Trip $trip)
    {
        if ($trip->driver_id !== auth()->id()) {
            abort(403);
        }

        // Only allow updating ongoing trips
        if ($trip->status !== 'ongoing') {
            return redirect()->route('driver.trips.show', $trip)
                ->with('error', 'Only ongoing trips can be updated.');
        }

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'km_awal' => 'required|integer|min:0',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tujuan' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'petugas_1' => 'required|string|max:255',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required|date_format:H:i',
        ]);

        // Handle photo update if new photo is uploaded
        if ($request->hasFile('foto_awal')) {
            // Delete old photo
            if ($trip->foto_awal) {
                Storage::disk('public')->delete($trip->foto_awal);
            }
            $validated['foto_awal'] = $request->file('foto_awal')->store('trips', 'public');
        }

        // Gabungkan tanggal dan jam menjadi datetime
        $validated['jam_out'] = $validated['tanggal_berangkat'] . ' ' . $validated['jam_berangkat'];

        // Remove temporary fields
        unset($validated['tanggal_berangkat'], $validated['jam_berangkat']);

        $trip->update($validated);

        return redirect()->route('driver.trips.show', $trip)
            ->with('success', 'Trip updated successfully.');
    }

    public function finishForm(Trip $trip)
    {
        if ($trip->driver_id !== auth()->id()) {
            abort(403);
        }

        // Only allow finishing ongoing trips
        if ($trip->status !== 'ongoing') {
            return redirect()->route('driver.trips.show', $trip)
                ->with('error', 'Only ongoing trips can be finished.');
        }

        return view('driver.trips.finish', compact('trip'));
    }

    public function finish(Request $request, Trip $trip)
    {
        if ($trip->driver_id !== auth()->id()) {
            abort(403);
        }

        if ($trip->status !== 'ongoing') {
            return back()->with('error', 'Only ongoing trips can be finished.');
        }

        $validated = $request->validate([
            'km_akhir' => 'required|integer|min:' . $trip->km_awal,
            'foto_akhir' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'petugas_2' => 'required|string|max:255',
            'tanggal_kembali' => 'required|date',
            'jam_kembali' => 'required|date_format:H:i',
        ]);

        $fotoAkhirPath = $request->file('foto_akhir')->store('trips', 'public');

        // Gabungkan tanggal dan jam menjadi datetime
        $jamIn = $validated['tanggal_kembali'] . ' ' . $validated['jam_kembali'];

        $trip->update([
            'km_akhir' => $validated['km_akhir'],
            'foto_akhir' => $fotoAkhirPath,
            'petugas_2' => $validated['petugas_2'],
            'jam_in' => $jamIn,
            'status' => 'completed',
        ]);

        $trip->vehicle->update(['status' => 'available']);

        return redirect()->route('driver.trips.show', $trip)
            ->with('success', 'Trip completed successfully. Waiting for verification.');
    }

    /**
     * Driver is NOT allowed to delete trips
     * This method will always return 403 Forbidden
     */
    public function destroy(Trip $trip)
    {
        abort(403, 'Drivers are not authorized to delete trips.');
    }
}
