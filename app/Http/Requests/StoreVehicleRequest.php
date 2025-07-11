<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identification_name' => 'required|string|max:255',
            'prefix' => 'required|string|max:255|unique:vehicles,prefix',
            'license_plate' => 'required|string|max:10|unique:vehicles,license_plate',
            'model' => 'required|string|max:255',
            'chassis' => 'required|string|max:255|unique:vehicles,chassis',
            'capacity' => 'required|integer',
            'vehicle_type' => 'required|string|max:255',
            'seating_layout' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'amenities' => 'nullable|array',
        ];
    }
}
