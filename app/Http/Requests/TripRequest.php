<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\DriverIsAvailable;
use App\Rules\VehicleIsAvailable;
use App\Constants\Trip;
use App\Rules\CnhIsNotExpired;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TripRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->isMethod('post')) {
            $this->merge([
                'status' => Trip::STATUS_IN_PROGRESS,
            ]);
        }
    }

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
        $tripId = $this->route('trip') ? $this->route('trip')->id : null;

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('trips')->where(function ($query) {
                    return $query->where('departure_date', $this->departure_date)
                        ->where('departure_time', $this->departure_time);
                })->ignore($tripId),
            ],
            'departure_date' => ['required', 'date'],
            'departure_time' => ['required', 'date_format:H:i'],
            'origin' => ['required', 'string', 'max:255'],
            'destination' => ['required', 'string', 'max:255', 'different:origin'],
            'rules' => ['required', 'string', 'max:255'],
            'passenger_price' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'max_passengers' => ['required', 'integer', 'min:1', 'max:100'],
            'vehicle_id' => [
                'required',
                'exists:vehicles,id',
                new VehicleIsAvailable($this->departure_date, $this->departure_time, $tripId)
            ],
            'driver_id' => [
                'required',
                'exists:drivers,id',
                new CnhIsNotExpired,
                new DriverIsAvailable($this->departure_date, $this->departure_time, $tripId)
            ],
            'status' => [Rule::in(Trip::STATUSES)],
        ];

        if ($this->isMethod('post')) {
            $rules['departure_date'][] = 'after_or_equal:today';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['departure_date'] = ['required', 'date'];
        }

        return $rules;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $errorCount = $errors->count();
        $errorTitle = $errorCount > 1 ? "Foram encontrados {$errorCount} erros" : 'Ocorreu um erro';

        $errorMessage = '<ul class="text-start">';
        foreach ($errors->all() as $error) {
            $errorMessage .= "<li>{$error}</li>";
        }
        $errorMessage .= '</ul>';

        $response = redirect()
            ->back()
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors)
            ->with('show_validation_error_alert', true)
            ->with('validation_error_title', $errorTitle)
            ->with('validation_error_message', $errorMessage);

        throw new HttpResponseException($response);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome da viagem',
            'status' => 'status',
            'departure_date' => 'data de partida',
            'departure_time' => 'horário de partida',
            'origin' => 'origem',
            'destination' => 'destino',
            'route' => 'rota',
            'passenger_price' => 'valor da passagem',
            'max_passengers' => 'número máximo de passageiros',
            'vehicle_id' => 'veículo',
            'driver_id' => 'motorista',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da viagem é obrigatório.',
            'name.max' => 'O nome da viagem não pode ter mais de 255 caracteres.',
            'name.unique' => 'Já existe uma viagem com este nome na mesma data e horário.',

            'departure_date.required' => 'A data de partida é obrigatória.',
            'departure_date.date' => 'A data de partida deve ser uma data válida.',
            'departure_date.after_or_equal' => 'A data de partida deve ser hoje ou uma data futura.',

            'departure_time.required' => 'O horário de partida é obrigatório.',
            'departure_time.date_format' => 'O horário de partida deve estar no formato HH:MM.',

            'origin.required' => 'A origem é obrigatória.',
            'origin.max' => 'A origem não pode ter mais de 255 caracteres.',

            'destination.required' => 'O destino é obrigatório.',
            'destination.max' => 'O destino não pode ter mais de 255 caracteres.',
            'destination.different' => 'O destino deve ser diferente da origem.',

            'route.required' => 'A rota é obrigatória.',
            'route.max' => 'A rota não pode ter mais de 255 caracteres.',

            'passenger_price.required' => 'O valor da passagem é obrigatório.',
            'passenger_price.numeric' => 'O valor da passagem deve ser um número.',
            'passenger_price.min' => 'O valor da passagem deve ser maior ou igual a zero.',
            'passenger_price.max' => 'O valor da passagem não pode ser maior que R$ 9.999,99.',

            'max_passengers.required' => 'O número máximo de passageiros é obrigatório.',
            'max_passengers.integer' => 'O número máximo de passageiros deve ser um número inteiro.',
            'max_passengers.min' => 'O número máximo de passageiros deve ser pelo menos 1.',
            'max_passengers.max' => 'O número máximo de passageiros não pode ser maior que 100.',

            'vehicle_id.required' => 'O veículo é obrigatório.',
            'vehicle_id.exists' => 'O veículo selecionado não existe.',

            'driver_id.required' => 'O motorista é obrigatório.',
            'driver_id.exists' => 'O motorista selecionado não existe.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: Em andamento, Concluída ou Cancelada.',
        ];
    }
}
