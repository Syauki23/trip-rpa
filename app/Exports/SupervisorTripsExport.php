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
        $query = Trip::with(['driver', 'vehicle'])
            ->where('status', 'completed');

        // Filter tanggal dari (match controller)
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('updated_at', '>=', $this->filters['date_from']);
        }

        // Filter tanggal sampai
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('updated_at', '<=', $this->filters['date_to']);
        }

        // Filter driver
        if (!empty($this->filters['driver'])) {
            $driver = $this->filters['driver'];
            $query->whereHas('driver', function($q) use ($driver) {
                $q->where('name', 'like', "%$driver%");
            });
        }

        // Filter status
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->orderBy('updated_at', 'desc');
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
            'Tanggal Dibuat'
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
            $trip->km_awal,
            $trip->km_akhir ?? '-',
            $trip->km_akhir ? ($trip->km_akhir - $trip->km_awal) : '-',
            $trip->jam_out ? $trip->jam_out->format('d/m/Y H:i') : '-',
            $trip->jam_in ? $trip->jam_in->format('d/m/Y H:i') : '-',
            ucfirst($trip->status),
            $trip->created_at->format('d/m/Y H:i'),
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