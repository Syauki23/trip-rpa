<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TripsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $trips;
    
    public function __construct($trips)
    {
        $this->trips = $trips;
    }
    
    public function collection()
    {
        return $this->trips;
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'Driver',
            'Kendaraan',
            'Plat Nomor',
            'Tujuan',
            'Keperluan',
            'KM Awal',
            'KM Akhir',
            'Total KM',
            'Jam Keluar',
            'Jam Masuk',
            'Status',
            'Tanggal Dibuat',
        ];
    }
    
    public function map($trip): array
    {
        return [
            $trip->id,
            $trip->driver->name ?? '-',
            $trip->vehicle->name ?? '-',
            $trip->vehicle->plate_number ?? '-',
            $trip->tujuan,
            $trip->keperluan,
            $trip->km_awal ?? '-',
            $trip->km_akhir ?? '-',
            $trip->total_km ?? '-',
            $trip->jam_out ? $trip->jam_out->format('d/m/Y H:i') : '-',
            $trip->jam_in ? $trip->jam_in->format('d/m/Y H:i') : '-',
            ucfirst($trip->status),
            $trip->created_at->format('d/m/Y H:i'),
        ];
    }
}
