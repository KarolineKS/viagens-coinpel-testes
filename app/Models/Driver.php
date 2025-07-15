<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'birth_date',
        'registration_number',
        'cpf',
        'rg',
        'zip_code',
        'street',
        'number',
        'city',
        'state',
        'email',
        'phone',
        'cnh_category',
        'cnh_number',
        'cnh_expiry_date',
        'profile_photo',
    ];

    protected $casts = [
        'birth_date' => 'date:Y-m-d',
        'cnh_expiry_date' => 'date:Y-m-d',
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_address',
        'city_state',
        'formatted_cpf',
        'formatted_phone',
        'profile_photo_url',
        'formatted_birth_date',
        'formatted_cnh_expiry_date',
    ];

    /**
     * Returns the driver's full address as a string combining street and number.
     *
     * @return string The full address in the format "street, number".
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->street}, {$this->number}";
    }

    /****
     * Returns the driver's city and state as a single string in the format "city/state".
     *
     * @return string The concatenated city and state.
     */
    public function getCityStateAttribute(): string
    {
        return "{$this->city}/{$this->state}";
    }

    /**
     * Determines whether the driver's CNH (driver's license) has expired.
     *
     * @return bool True if the CNH expiry date is set and in the past; otherwise, false.
     */
    public function isCnhExpired(): bool
    {
        return $this->cnh_expiry_date ? $this->cnh_expiry_date->isPast() : false;
    }

    /**
     * Returns the CPF number formatted as xxx.xxx.xxx-xx.
     *
     * If the CPF is empty, returns an empty string.
     *
     * @return string The formatted CPF or an empty string if not set.
     */
    public function getFormattedCpfAttribute(): string
    {
        if (empty($this->cpf)) {
            return '';
        }
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    /**
     * Returns the phone number formatted as (xx) xxxx-xxxx or (xx) xxxxx-xxxx.
     *
     * If the phone number is not set, returns an empty string.
     * @return string The formatted phone number or an empty string if not available.
     */
    public function getFormattedPhoneAttribute(): string
    {
        if (empty($this->phone)) {
            return '';
        }
        return preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $this->phone);
    }

    /**
     * Returns the driver's birth date formatted as `d/m/Y`, or null if not set.
     *
     * @return string|null The formatted birth date, or null if unavailable.
     */
    public function getFormattedBirthDateAttribute(): ?string
    {
        return $this->birth_date ? $this->birth_date->format('d/m/Y') : null;
    }

    /**
     * Returns the CNH expiry date formatted as `d/m/Y`, or null if not set.
     *
     * @return string|null The formatted CNH expiry date, or null if unavailable.
     */
    public function getFormattedCnhExpiryDateAttribute(): ?string
    {
        return $this->cnh_expiry_date ? $this->cnh_expiry_date->format('d/m/Y') : null;
    }

    /**
     * Returns the full URL to the driver's profile photo if set, or null otherwise.
     *
     * @return string|null The URL of the profile photo, or null if no photo is available.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo ? asset('storage/' . $this->profile_photo) : null;
    }

    /**
     * Returns up to two uppercase initials from the driver's name for use as an avatar placeholder.
     *
     * If the name contains multiple words, the initials are taken from the first character of each of the first two words. If the name is a single word, the first character is used.
     *
     * @return string The driver's initials in uppercase.
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $name) {
            if (!empty($name)) {
                $initials .= strtoupper($name[0]);
                if (strlen($initials) >= 2) break;
            }
        }

        return $initials ?: strtoupper(substr($this->name, 0, 1));
    }
}
