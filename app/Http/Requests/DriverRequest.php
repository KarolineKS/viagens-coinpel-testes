<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Handle Driver Request
 * 
 * @property-read string $name
 * @property-read string $birth_date
 * @property-read string $registration_number
 * @property-read string $cpf
 * @property-read string $rg
 * @property-read string $zip_code
 * @property-read string $street
 * @property-read string $number
 * @property-read string $city
 * @property-read string $state
 * @property-read string $email
 * @property-read string $phone
 * @property-read string $cnh_category
 * @property-read string $cnh_number
 * @property-read string $cnh_expiry_date
 * @property-read mixed $profile_photo
 */
class DriverRequest extends FormRequest
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
        $driverId = $this->route('driver') ? $this->route('driver')->id : null;

        return [

            'name' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'registration_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('drivers')->ignore($driverId),
            ],
            'cpf' => [
                'required',
                'string',
                'size:14',
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                Rule::unique('drivers')->ignore($driverId),
            ],
            'rg' => 'required|string|max:20',


            'zip_code' => 'required|string|size:9|regex:/^\d{5}-\d{3}$/',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|size:2',


            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('drivers')->ignore($driverId),
            ],
            'phone' => 'required|string|max:20',


            'cnh_category' => 'required|in:A,B,C,D,E,AB,AC,AD,AE',
            'cnh_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('drivers')->ignore($driverId),
            ],
            'cnh_expiry_date' => 'required|date|after:today',

            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'registration_number.required' => 'A matrícula é obrigatória.',
            'registration_number.unique' => 'Esta matrícula já está em uso.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00.',
            'cpf.unique' => 'Este CPF já está em uso.',
            'rg.required' => 'O RG é obrigatório.',
            'zip_code.required' => 'O CEP é obrigatório.',
            'zip_code.regex' => 'O CEP deve estar no formato 00000-000.',
            'street.required' => 'O logradouro é obrigatório.',
            'number.required' => 'O número é obrigatório.',
            'city.required' => 'A cidade é obrigatória.',
            'state.required' => 'O estado é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'phone.required' => 'O telefone é obrigatório.',
            'cnh_category.required' => 'A categoria da CNH é obrigatória.',
            'cnh_category.in' => 'Selecione uma categoria válida.',
            'cnh_number.required' => 'O número da CNH é obrigatório.',
            'cnh_number.unique' => 'Este número de CNH já está em uso.',
            'cnh_expiry_date.required' => 'A data de validade da CNH é obrigatória.',
            'cnh_expiry_date.after' => 'A CNH deve ter validade futura.',
            'profile_photo.image' => 'O arquivo deve ser uma imagem.',
            'profile_photo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'profile_photo.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }
}
