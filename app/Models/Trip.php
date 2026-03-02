<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'driver_name',
        'vehicle_id',
        'km_awal',
        'km_akhir',
        'foto_awal',
        'foto_akhir',
        'tujuan',
        'keperluan',
        'petugas_1',
        'petugas_2',
        'jam_out',
        'jam_in',
        'status'
    ];

    protected $casts = [
        'jam_out' => 'datetime',
        'jam_in' => 'datetime',
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getTotalKmAttribute(): ?int
    {
        if ($this->km_akhir && $this->km_awal) {
            return $this->km_akhir - $this->km_awal;
        }
        return null;
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-info">Approved</span>',
            'ongoing' => '<span class="badge bg-primary">Ongoing</span>',
            'completed' => '<span class="badge bg-success">Completed</span>',
            'verified' => '<span class="badge bg-dark">Verified</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}
