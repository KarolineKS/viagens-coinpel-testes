<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'identification_name',
        'prefix',
        'license_plate',
        'model',
        'chassis',
        'vehicle_type',
        'capacity',
        'year',
        'seating_layout',
        'has_internet',
        'has_wc',
        'has_power_outlet',
        'has_ac',
        'has_fridge',
        'has_heating',
        'has_video',
    ];

    /**
     * Get the trips assigned to this vehicle.
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
