@extends('layouts.app')

@section('title', 'Usuários')

@section('action-type', 'offcanvas')
@section('action-target', '#userFormOffcanvas')
@section('action-entity', 'usuário')

@section('search-action', route('users.index'))
@section('search-placeholder', 'Pesquisar usuário')

@section('content')
<x-table>
    <x-slot name="head">
        <th>Usuário</th>
        <th>E-mail</th>
        <th>Status</th>
        <th width="50"></th>
    </x-slot>

    <x-slot name="body">
        @forelse ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->is_blocked ?? false)
                <span class="badge bg-danger">Bloqueado</span>
                @else
                <span class="badge bg-success">Ativo</span>
                @endif
            </td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-ghost" type="button" data-bs-toggle="dropdown">
                        <x-icon name="three-dots-vertical" />
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ route('users.index', ['edit' => $user->id]) }}">
                                <x-icon name="edit" />
                                <span>Editar usuário</span>
                            </a>
                        </li>

                        @if(!($user->is_blocked ?? false))
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmBlockUserModal{{ $user->id }}">
                                <x-icon name="x-circle" />
                                <span>Bloquear usuário</span>
                            </button>
                        </li>
                        @else
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmUnblockUserModal{{ $user->id }}">
                                <x-icon name="check-circle" />
                                <span>Desbloquear usuário</span>
                            </button>
                        </li>
                        @endif

                        @if($user->id !== auth()->id())
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteUserModal{{ $user->id }}">
                                <x-icon name="delete" />
                                <span>Deletar usuário</span>
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted py-4">
                @if(request('search'))
                Nenhum usuário encontrado para "{{ request('search') }}".
                @else
                Nenhum usuário cadastrado.
                @endif
            </td>
        </tr>
        @endforelse
    </x-slot>
</x-table>

@if($users->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $users->links() }}
</div>
@endif

@include('users.partials.form-offcanvas')

@foreach($users as $user)
@if($user->id !== auth()->id())
<x-custom-alert
    type="danger"
    id="confirmDeleteUserModal{{ $user->id }}"
    :message="'Tem certeza que deseja deletar o usuário <strong>' . $user->name . '</strong>?'"
    :showCancel="true"
    :confirmAction="route('users.destroy', $user)"
    confirmText="Deletar usuário"
    cancelText="Cancelar" />
@endif

<!-- Modal para bloquear usuário -->
@if(!($user->is_blocked ?? false))
<x-custom-alert
    type="warning"
    id="confirmBlockUserModal{{ $user->id }}"
    :message="'Tem certeza que deseja bloquear o usuário <strong>' . $user->name . '</strong>?<br/><small>O usuário não poderá mais fazer login no sistema.</small>'"
    :showCancel="true"
    :confirmAction="route('users.toggle-block', $user)"
    confirmText="Bloquear usuário"
    cancelText="Cancelar"
    method="PATCH" />
@endif

<!-- Modal para desbloquear usuário -->
@if($user->is_blocked ?? false)
<x-custom-alert
    type="info"
    id="confirmUnblockUserModal{{ $user->id }}"
    :message="'Tem certeza que deseja desbloquear o usuário <strong>' . $user->name . '</strong>?<br/><small>O usuário voltará a ter acesso ao sistema.</small>'"
    :showCancel="true"
    :confirmAction="route('users.toggle-block', $user)"
    confirmText="Desbloquear usuário"
    cancelText="Cancelar"
    method="PATCH" />
@endif
@endforeach

@endsection