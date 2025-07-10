<?php

namespace App\Http\Controllers\Auth;

use App\Constants\SessionKeys;
use App\Constants\ValidationConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(LoginRequest $request): Response
    {
        if (!$request->tryToLogin()) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Usuário não encontrado ou senha incorreta!');
        }

        if ($this->isPasswordChangeRequired()) {
            return response()->view('auth.login', [
                'requirePasswordChange' => true,
                'minPasswordLength' => ValidationConstants::MIN_PASSWORD_LENGTH,
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Login realizado com sucesso!');
    }

    /**
     * Check if the user is required to change their password.
     *
     * If the session key is present, it will be forgotten after the check.
     */

    protected function isPasswordChangeRequired(): bool
    {
        if (session()->has(SessionKeys::REQUIRE_PASSWORD_CHANGE)) {
            session()->forget(SessionKeys::REQUIRE_PASSWORD_CHANGE);

            return true;
        }

        return false;
    }
}
