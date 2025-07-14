<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        $query = User::query();


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);


        $autoOpen = $request->has('create');
        $editUser = null;


        if ($request->has('edit')) {
            $editUser = User::find($request->edit);
            $autoOpen = true;
        }

        return view('users.index', compact('users', 'autoOpen', 'editUser'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_login' => true,
        ]);

        return Redirect::route('users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return Redirect::route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return Redirect::route('users.index')
                ->with('error', 'Você não pode deletar sua própria conta.');
        }

        $user->delete();

        return Redirect::route('users.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }

    /**
     * Toggle the blocked status of the specified user.
     */
    public function toggleBlock(User $user)
    {

        if ($user->id === Auth::id()) {
            return Redirect::route('users.index')
                ->with('error', 'Você não pode bloquear sua própria conta.');
        }

        $user->update([
            'is_blocked' => !$user->is_blocked
        ]);

        $status = $user->is_blocked ? 'bloqueado' : 'desbloqueado';

        return Redirect::route('users.index')
            ->with('success', "Usuário {$status} com sucesso!");
    }
}
