<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Update the authenticated user's password.
     *
     * Marks the first login as completed and forces logout for new authentication.
     *
     * @param ChangePasswordRequest $request Validated new password data
     * @return \Illuminate\Http\RedirectResponse Redirect to login with success message
     */

    public function store(ChangePasswordRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Usuário não encontrado.');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'first_login' => false,
        ]);

        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Senha alterada com sucesso! Faça o login com sua nova senha.');
    }
}
