<?php

namespace App\Http\Requests;

use App\Constants\SessionKeys;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Handle Login Request
 * 
 * @property-read string $email
 * @property-read string $password
 */


class LoginRequest extends FormRequest
{
    /**
     * Reason why login failed
     */
    public ?string $loginFailureReason = null;

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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    /**
     * Attempt to login in the system.
     *
     * @return bool
     */

    public function tryToLogin(): bool
    {
        $remember = $this->boolean('remember');

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $remember)) {

            $user = Auth::user();

            if ($user->is_blocked) {
                Auth::logout();

                $this->loginFailureReason = 'blocked';

                session()->put('loginFailureReason', $this->loginFailureReason);

                return false;
            }

            if ($user->first_login) {
                session()->put(SessionKeys::REQUIRE_PASSWORD_CHANGE, true);
            }

            return true;
        }

        $this->loginFailureReason = 'invalidCredentials';
        return false;
    }


    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
        ];
    }
}
