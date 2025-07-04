<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        if ($user = User::query()
            ->where('email', "=", $this->email)
            ->first()
        ) {

            if (Hash::check($this->password, $user->password)) {
                Auth::login($user);

                return true;
            };
        }

        return false;
    }
}
