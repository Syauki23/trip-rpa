<?php

namespace App\Exports;

use App\Models\Trip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TripsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Trip::with(['driver', 'vehicle'])->get(); // Ambil SEMUA DATA
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Kendaraan',
            'Nopol',
            'KM Awal',
            'Jam Keluar',
            'Tujuan',
            'Keperluan',
            'KM Akhir',
            'Jam Kembali',
            'Petugas 1',
            'Petugas 2',
        ];
    }
    
    public function map($trip): array
    {
        return [
            $trip->id,
            $trip->jam_out ? $trip->jam_out->format('d/m/Y') : '-',
            $trip->vehicle->name ?? '-',
            $trip->vehicle->plate_number ?? '-',
            $trip->km_awal ?? '-',
            $trip->jam_out ? $trip->jam_out->format('H:i') : '-',
            $trip->tujuan ?? '-',
            $trip->keperluan ?? '-',
            $trip->km_akhir ?? '-',
            $trip->jam_in ? $trip->jam_in->format('H:i') : '-',
            $trip->petugas_1 ?? '-',
            $trip->petugas_2 ?? '-',
        ];
    }
}