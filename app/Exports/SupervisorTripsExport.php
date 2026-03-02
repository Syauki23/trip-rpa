<?php

namespace App\Exports;

use App\Models\Trip;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SupervisorTripsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        // Ambil SEMUA data trip tanpa filter
        return Trip::with(['driver', 'vehicle'])
            ->orderBy('jam_out', 'desc');
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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F97316']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]
            ],
        ];
    }
}