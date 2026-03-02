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
        
        // Total trip approved
        $totalApproved = Trip::where('status', 'approved')->count();
        
        // Total trip on trip (ongoing)
        $totalOnTrip = Trip::where('status', 'ongoing')->count();
        
        // Total trip selesai
        $totalCompleted = Trip::where('status', 'completed')->count();
        
        // Total trip rejected
        $totalRejected = Trip::where('status', 'rejected')->count();
        
        // Data untuk Bar Chart - Status Perjalanan
        $statusData = [$totalPending, $totalApproved, $totalOnTrip, $totalCompleted, $totalRejected];
        
        // Data kendaraan untuk Donut Chart
        $vehiclesInUse = \App\Models\Vehicle::where('status', 'in_use')->count();
        $vehiclesAvailable = \App\Models\Vehicle::where('status', 'available')->count();
        $vehicleData = [$vehiclesInUse, $vehiclesAvailable];
        
        // Data perjalanan per hari untuk Line Chart (7 hari terakhir)
        $dataMingguan = [];
        $labelMingguan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labelMingguan[] = $date->locale('id')->isoFormat('ddd'); // Sen, Sel, Rab, etc
            $dataMingguan[] = Trip::whereDate('created_at', $date->format('Y-m-d'))->count();
        }
        
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
            'totalApproved',
            'totalOnTrip',
            'totalCompleted',
            'totalRejected',
            'statusData',
            'vehicleData',
            'dataMingguan',
            'labelMingguan',
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
    
    public function review(Request $request)
    {
        $query = Trip::with(['driver', 'vehicle'])
            ->where('status', 'completed');
        
        // Filter tanggal dari
        if ($request->filled('date_from')) {
            $query->whereDate('updated_at', '>=', $request->date_from);
        }
        
        // Filter tanggal sampai
        if ($request->filled('date_to')) {
            $query->whereDate('updated_at', '<=', $request->date_to);
        }
        
        // Filter driver
        if ($request->filled('driver')) {
            $query->whereHas('driver', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->driver . '%');
            });
        }
        
        // Filter status (untuk future use jika ada status lain)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $trips = $query->orderBy('updated_at', 'desc')->paginate(10);
        
        // Untuk dropdown driver
        $drivers = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'driver');
        })->orderBy('name')->get();
        
        return view('supervisor.trips.review', compact('trips', 'drivers'));
    }
    
    public function exportReview(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SupervisorTripsExport($request->all()),
            'perjalanan-selesai-' . date('Y-m-d') . '.xlsx'
        );
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

    public function verify(Trip $trip)
    {
        if ($trip->status !== 'completed') {
            return back()->with('error', 'Only completed trips can be verified.');
        }

        $trip->update(['status' => 'verified']);

        return back()->with('success', 'Trip verified successfully.');
    }

    public function create()
    {
        $vehicles = \App\Models\Vehicle::where('status', 'available')->get();
        $drivers = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'driver');
        })->get();
        
        return view('supervisor.trips.create', compact('vehicles', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'km_awal' => 'required|integer|min:0',
            'foto_awal' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tujuan' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'petugas_1' => 'nullable|string|max:255',
            'petugas_2' => 'nullable|string|max:255',
            'jam_out' => 'required|date',
        ]);

        $fotoAwalPath = $request->file('foto_awal')->store('trips', 'public');

        Trip::create([
            'driver_id' => $validated['driver_id'],
            'vehicle_id' => $validated['vehicle_id'],
            'km_awal' => $validated['km_awal'],
            'foto_awal' => $fotoAwalPath,
            'tujuan' => $validated['tujuan'],
            'keperluan' => $validated['keperluan'],
            'petugas_1' => $validated['petugas_1'] ?? null,
            'petugas_2' => $validated['petugas_2'] ?? null,
            'jam_out' => $validated['jam_out'],
            'status' => 'pending',
        ]);

        return redirect()->route('supervisor.trips.index')
            ->with('success', 'Trip created successfully.');
    }

    public function edit(Trip $trip)
    {
        $vehicles = \App\Models\Vehicle::where('status', 'available')
            ->orWhere('id', $trip->vehicle_id)
            ->get();
        $drivers = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'driver');
        })->get();
        
        return view('supervisor.trips.edit', compact('trip', 'vehicles', 'drivers'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'km_awal' => 'required|integer|min:0',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tujuan' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'petugas_1' => 'nullable|string|max:255',
            'petugas_2' => 'nullable|string|max:255',
            'jam_out' => 'required|date',
        ]);

        // Handle photo update if new photo is uploaded
        if ($request->hasFile('foto_awal')) {
            // Delete old photo
            if ($trip->foto_awal) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($trip->foto_awal);
            }
            $validated['foto_awal'] = $request->file('foto_awal')->store('trips', 'public');
        }

        $trip->update($validated);

        return redirect()->route('supervisor.trips.show', $trip)
            ->with('success', 'Trip updated successfully.');
    }

    public function destroy(Trip $trip)
    {
        // Delete photos if exist
        if ($trip->foto_awal) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($trip->foto_awal);
        }
        if ($trip->foto_akhir) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($trip->foto_akhir);
        }

        $trip->delete();

        return redirect()->route('supervisor.trips.index')
            ->with('success', 'Trip deleted successfully.');
    }
}
