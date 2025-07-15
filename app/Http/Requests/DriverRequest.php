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
            'birth_date' => 'required|date|before:18 years ago',
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
            'rg' => [
                'required',
                'string',
                'max:20',
                Rule::unique('drivers')->ignore($driverId),
            ],


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

            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000', // 5MB, min 100x100, max 4000x4000
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
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',

            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
            'birth_date.before' => 'O motorista deve ser maior de 18 anos.',

            'registration_number.required' => 'A matrícula é obrigatória.',
            'registration_number.string' => 'A matrícula deve ser um texto válido.',
            'registration_number.max' => 'A matrícula deve ter no máximo 20 caracteres.',
            'registration_number.unique' => 'Esta matrícula já está em uso.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser um texto válido.',
            'cpf.size' => 'O CPF deve estar no formato 000.000.000-00.',
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00.',
            'cpf.unique' => 'Este CPF já está em uso.',

            'rg.required' => 'O RG é obrigatório.',
            'rg.string' => 'O RG deve ser um texto válido.',
            'rg.max' => 'O RG deve ter no máximo 20 caracteres.',
            'rg.unique' => 'Este RG já está em uso.',

            'zip_code.required' => 'O CEP é obrigatório.',
            'zip_code.string' => 'O CEP deve ser um texto válido.',
            'zip_code.size' => 'O CEP deve estar no formato 00000-000.',
            'zip_code.regex' => 'O CEP deve estar no formato 00000-000.',

            'street.required' => 'O logradouro é obrigatório.',
            'street.string' => 'O logradouro deve ser um texto válido.',
            'street.max' => 'O logradouro deve ter no máximo 255 caracteres.',
            'number.required' => 'O número é obrigatório.',
            'number.string' => 'O número deve ser um texto válido.',
            'number.max' => 'O número deve ter no máximo 10 caracteres.',
            'city.required' => 'A cidade é obrigatória.',
            'city.string' => 'A cidade deve ser um texto válido.',
            'city.max' => 'A cidade deve ter no máximo 100 caracteres.',
            'state.required' => 'O estado é obrigatório.',
            'state.string' => 'O estado deve ser um texto válido.',
            'state.size' => 'O estado deve ter 2 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.email' => 'Digite um e-mail válido.',
            'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',

            'phone.required' => 'O telefone é obrigatório.',
            'phone.string' => 'O telefone deve ser um texto válido.',
            'phone.max' => 'O telefone deve ter no máximo 20 caracteres.',

            'cnh_category.required' => 'A categoria da CNH é obrigatória.',
            'cnh_category.in' => 'Selecione uma categoria válida.',
            'cnh_number.required' => 'O número da CNH é obrigatório.',
            'cnh_number.string' => 'O número da CNH deve ser um texto válido.',
            'cnh_number.max' => 'O número da CNH deve ter no máximo 20 caracteres.',
            'cnh_number.unique' => 'Este número de CNH já está em uso.',
            'cnh_expiry_date.required' => 'A data de validade da CNH é obrigatória.',
            'cnh_expiry_date.date' => 'A data de validade da CNH deve ser uma data válida.',
            'cnh_expiry_date.after' => 'A CNH deve ter validade futura.',

            'profile_photo.image' => 'O arquivo deve ser uma imagem.',
            'profile_photo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, webp.',
            'profile_photo.max' => 'A imagem não pode ter mais de 5MB.',
            'profile_photo.dimensions' => 'A imagem deve ter pelo menos 100x100 pixels e no máximo 4000x4000 pixels.',
        ];
    }
}
