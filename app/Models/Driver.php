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
     * Get the driver's full address.
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->street}, {$this->number}";
    }

    /**
     * Get the driver's city and state.
     */
    public function getCityStateAttribute(): string
    {
        return "{$this->city}/{$this->state}";
    }

    /**
     * Check if CNH is expired.
     */
    public function isCnhExpired(): bool
    {
        return $this->cnh_expiry_date ? $this->cnh_expiry_date->isPast() : false;
    }

    /**
     * Scope a query to only include active drivers.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Get formatted CPF.
     */
    public function getFormattedCpfAttribute(): string
    {
        if (empty($this->cpf)) {
            return '';
        }
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    /**
     * Get formatted phone.
     */
    public function getFormattedPhoneAttribute(): string
    {
        if (empty($this->phone)) {
            return '';
        }
        return preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $this->phone);
    }

    /**
     * Get formatted birth date.
     */
    public function getFormattedBirthDateAttribute(): ?string
    {
        return $this->birth_date ? $this->birth_date->format('d/m/Y') : null;
    }

    /**
     * Get formatted CNH expiry date.
     */
    public function getFormattedCnhExpiryDateAttribute(): ?string
    {
        return $this->cnh_expiry_date ? $this->cnh_expiry_date->format('d/m/Y') : null;
    }

    /**
     * Get the profile photo URL.
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo ? asset('storage/' . $this->profile_photo) : null;
    }

    /**
     * Get driver initials for avatar placeholder.
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
