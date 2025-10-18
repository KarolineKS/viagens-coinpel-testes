<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Handle Vehicle Request
 * 
 * @property-read string $identification_name
 * @property-read string $prefix
 * @property-read string $license_plate
 * @property-read string $model
 * @property-read string $chassis
 * @property-read int $capacity
 * @property-read string $vehicle_type
 * @property-read string $seating_layout
 * @property-read int $year
 * @property-read array $amenities
 */

class VehicleRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $vehicleId = $isUpdate ? $this->route('vehicle')->id : null;

        return [
            'identification_name' => 'required|string|max:255',
            'prefix' => 'required|string|max:255|unique:vehicles,prefix' . ($isUpdate ? ',' . $vehicleId : ''),
            'license_plate' => 'required|string|max:10|unique:vehicles,license_plate' . ($isUpdate ? ',' . $vehicleId : ''),
            'model' => 'required|string|max:255',
            'chassis' => 'required|string|max:255|unique:vehicles,chassis' . ($isUpdate ? ',' . $vehicleId : ''),
            'capacity' => 'required|integer|min:1',
            'vehicle_type' => 'required|string|max:255',
            'seating_layout' => 'required|string|in:Semi-Leito,Leito,Convencional',
            'year' => 'required|integer|digits:4|min:1950|max:' . (date('Y') + 1),
            'amenities' => 'nullable|array',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'identification_name.required' => 'O nome de identificação é obrigatório.',
            'identification_name.max' => 'O nome de identificação não pode ter mais de 255 caracteres.',

            'prefix.required' => 'O prefixo é obrigatório.',
            'prefix.max' => 'O prefixo não pode ter mais de 255 caracteres.',
            'prefix.unique' => 'Este prefixo já está sendo usado por outro veículo.',

            'license_plate.required' => 'A placa é obrigatória.',
            'license_plate.max' => 'A placa não pode ter mais de 10 caracteres.',
            'license_plate.unique' => 'Esta placa já está sendo usada por outro veículo.',

            'model.required' => 'O modelo é obrigatório.',
            'model.max' => 'O modelo não pode ter mais de 255 caracteres.',

            'chassis.required' => 'O chassi é obrigatório.',
            'chassis.max' => 'O chassi não pode ter mais de 255 caracteres.',
            'chassis.unique' => 'Este chassi já está sendo usado por outro veículo.',

            'capacity.required' => 'A capacidade é obrigatória.',
            'capacity.integer' => 'A capacidade deve ser um número inteiro.',
            'capacity.min' => 'A capacidade deve ser pelo menos 1.',

            'vehicle_type.required' => 'O tipo de veículo é obrigatório.',
            'vehicle_type.max' => 'O tipo de veículo não pode ter mais de 255 caracteres.',

            'seating_layout.required' => 'A bancada é obrigatória.',
            'seating_layout.in' => 'A bancada deve ser um dos seguintes valores: Semi-Leito, Leito, Convencional.',

            'year.required' => 'O ano é obrigatório.',
            'year.integer' => 'O ano deve ser um número inteiro.',
            'year.digits' => 'O ano deve ter exatamente 4 dígitos.',
            'year.min' => 'O ano deve ser pelo menos 1950.',
            'year.max' => 'O ano não pode ser maior que ' . (date('Y') + 1) . '.',
        ];
    }
}
