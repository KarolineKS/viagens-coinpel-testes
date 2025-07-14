<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
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
}
