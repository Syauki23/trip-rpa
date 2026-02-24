<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Perjalanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-approved { background-color: #17a2b8; color: #fff; }
        .badge-ongoing { background-color: #007bff; color: #fff; }
        .badge-completed { background-color: #28a745; color: #fff; }
        .badge-rejected { background-color: #dc3545; color: #fff; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN REKAP PERJALANAN</h2>
        <p>Trip Management System</p>
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Driver</th>
                <th>Kendaraan</th>
                <th>Tujuan</th>
                <th>KM Awal</th>
                <th>KM Akhir</th>
                <th>Total KM</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
                <tr>
                    <td>#{{ $trip->id }}</td>
                    <td>{{ $trip->driver->name ?? '-' }}</td>
                    <td>{{ $trip->vehicle->name ?? '-' }}<br>{{ $trip->vehicle->plate_number ?? '-' }}</td>
                    <td>{{ $trip->tujuan }}</td>
                    <td>{{ $trip->km_awal ? number_format($trip->km_awal) : '-' }}</td>
                    <td>{{ $trip->km_akhir ? number_format($trip->km_akhir) : '-' }}</td>
                    <td>{{ $trip->total_km ? number_format($trip->total_km) : '-' }}</td>
                    <td>
                        @if($trip->status === 'pending')
                            <span class="badge badge-pending">Menunggu</span>
                        @elseif($trip->status === 'approved')
                            <span class="badge badge-approved">Disetujui</span>
                        @elseif($trip->status === 'ongoing')
                            <span class="badge badge-ongoing">Sedang Berjalan</span>
                        @elseif($trip->status === 'completed')
                            <span class="badge badge-completed">Selesai</span>
                        @elseif($trip->status === 'rejected')
                            <span class="badge badge-rejected">Ditolak</span>
                        @endif
                    </td>
                    <td>{{ $trip->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $trips->count() }} perjalanan</p>
    </div>
</body>
</html>
