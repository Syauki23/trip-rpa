<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plate_number',
        'status'
    ];

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
