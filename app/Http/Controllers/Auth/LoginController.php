<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if ($request->tryToLogin()) {

            if (session()->has('require_password_change')) {
                session()->forget('require_password_change');

                return view('auth.login', ['requirePasswordChange' => true]);
            }

            return redirect()->route('dashboard')
                ->with('success', 'Login realizado com sucesso!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Usuário não encontrado ou senha incorreta!');
    }
}
