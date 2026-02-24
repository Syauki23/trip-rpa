<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TripsExport;

class TripReportController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::all();
        
        $query = Trip::with(['driver', 'vehicle']);
        
        // Filter berdasarkan kendaraan
        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $trips = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.reports.trips', compact('trips', 'vehicles'));
    }
    
    public function exportExcel(Request $request)
    {
        $query = Trip::with(['driver', 'vehicle']);
        
        // Filter berdasarkan kendaraan
        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $trips = $query->orderBy('created_at', 'desc')->get();
        
        // Generate Excel file
        $filename = 'laporan-perjalanan-' . date('Y-m-d-His') . '.xlsx';
        
        return Excel::download(new TripsExport($trips), $filename);
    }
    
    public function exportPdf(Request $request)
    {
        $query = Trip::with(['driver', 'vehicle']);
        
        // Filter berdasarkan kendaraan
        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $trips = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('admin.reports.trips-pdf', compact('trips'));
        
        $filename = 'laporan-perjalanan-' . date('Y-m-d-His') . '.pdf';
        
        return $pdf->download($filename);
    }
}
