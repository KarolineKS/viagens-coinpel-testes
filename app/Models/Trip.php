<?php

namespace App\Models;

use App\Constants\Trip as TripConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'departure_date',
        'departure_time',
        'origin',
        'destination',
        'route',
        'rules',
        'passenger_price',
        'max_passengers',
        'vehicle_id',
        'driver_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'departure_date' => 'date',
        'departure_time' => 'datetime:H:i',
        'passenger_price' => 'decimal:2',
        'max_passengers' => 'integer',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($trip) {
            if ($trip->isDirty('origin') || $trip->isDirty('destination')) {
                $trip->route = $trip->origin . ' > ' . $trip->destination;
            }
        });
    }

    /**
     * Get the vehicle associated with the trip.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the driver associated with the trip.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Scope a query to only include trips with a specific status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }


    /**
     * Scope a query to only include trips in progress.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', TripConstants::STATUS_IN_PROGRESS);
    }

    /**
     * Scope a query to only include completed trips.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', TripConstants::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include cancelled trips.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', TripConstants::STATUS_CANCELLED);
    }

    /**
     * Get formatted departure date and time.
     *
     * @return string
     */
    public function getFormattedDepartureDateTimeAttribute(): string
    {
        if (!$this->departure_date || !$this->departure_time) {
            return '';
        }

        return $this->departure_date->format('d/m/Y') . ' às ' . $this->departure_time->format('H:i');
    }

    /**
     * Get status in Portuguese.
     *
     * @return string
     */
    public function getStatusInPortugueseAttribute(): string
    {
        return match ($this->status) {
            TripConstants::STATUS_IN_PROGRESS => 'Em andamento',
            TripConstants::STATUS_COMPLETED => 'Completa',
            TripConstants::STATUS_CANCELLED => 'Cancelada',
            default => $this->status,
        };
    }
}
