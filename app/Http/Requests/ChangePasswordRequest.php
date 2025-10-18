<?php

namespace App\Http\Requests;

use App\Constants\ValidationConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Password change request validation.
 *
 * Validates password change data including confirmation and security rules.
 * 
 * @property-read string $password New password field
 * @property-read string $password_confirmation Password confirmation field
 */

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True if user is authenticated
     */

    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'min:' . ValidationConstants::MIN_PASSWORD_LENGTH, 'confirmed'],
        ];
    }

    /**
     * Get custom validation error messages.
     *
     * @return array<string, string> Array of error messages
     */

    public function messages(): array
    {
        return [
            'password.required' => 'A nova senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo ' . ValidationConstants::MIN_PASSWORD_LENGTH . ' caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }
}
