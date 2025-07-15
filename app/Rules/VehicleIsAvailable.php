<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Trip;

class VehicleIsAvailable implements ValidationRule
{
    protected $departureDate;
    protected $departureTime;
    protected $tripId;

    public function __construct($departureDate, $departureTime, $tripId = null)
    {
        $this->departureDate = $departureDate;
        $this->departureTime = $departureTime;
        $this->tripId = $tripId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Trip::where('vehicle_id', $value)
            ->where('departure_date', $this->departureDate)
            ->where('departure_time', $this->departureTime);

        if ($this->tripId) {
            $query->where('id', '!=', $this->tripId);
        }

        if ($query->exists()) {
            $fail('O veículo selecionado já está alocado em outra viagem neste mesmo dia e horário.');
        }
    }
}
