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
     * Atualiza a senha do usuário autenticado e marca o primeiro login como concluído.
     *
     * @param  \App\Http\Requests\ChangePasswordRequest  
     * @return \Illuminate\Http\RedirectResponse 
     */

    public function store(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::id());

        $user->password = Hash::make($request->password);
        $user->first_login = false;
        $user->save();

        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Senha alterada com sucesso! Faça o login com sua nova senha.');
    }
}
