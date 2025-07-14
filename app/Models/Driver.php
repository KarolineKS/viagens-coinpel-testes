<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

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
        'birth_date' => 'date',
        'cnh_expiry_date' => 'date',
    ];

    /**
     * Get the driver's full address.
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->street}, {$this->number} - {$this->city}/{$this->state}";
    }

    /**
     * Check if CNH is expired.
     */
    public function isCnhExpired(): bool
    {
        return $this->cnh_expiry_date->isPast();
    }

    /**
     * Get formatted CPF.
     */
    public function getFormattedCpfAttribute(): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    /**
     * Get formatted phone.
     */
    public function getFormattedPhoneAttribute(): string
    {
        return preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $this->phone);
    }
}
