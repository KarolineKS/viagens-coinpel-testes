@extends('layouts.app')

@section('action-type', 'link')
@section('action-target', route('trips.create'))
@section('action-entity', 'viagem')

@section('search-placeholder', 'Pesquisar viagem')

@section('content')
<x-table>
    <x-slot name="head">
        <th>Status</th>
        <th>Nome</th>
        <th>Data</th>
        <th>Horário</th>
        <th>Rota</th>
        <th>Veículo</th>
        <th>Regra</th>
        <th>Motorista</th>
    </x-slot>

    <x-slot name="body">
        @forelse ($trips as $trip)
        <tr>
            <td>
                {{$trip -> status_in_portuguese}}
            </td>
            <td>{{ $trip->name }}</td>
            <td>{{ $trip->departure_date->format('d/m/Y') }}</td>
            <td>{{ $trip->departure_time->format('H:i') }}</td>
            <td>{{ $trip->route }}</td>
            <td>{{ $trip->vehicle->model }}</td>
            <td>{{ $trip->rules }}</td>
            <td>{{ $trip->driver->name }}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-ghost" type="button" data-bs-toggle="dropdown">
                        <x-icon name="three-dots-vertical" />
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('trips.edit', $trip) }}">
                                <x-icon name="edit" class="me-2" />
                                Editar viagem
                            </a>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal{{ $trip->id }}">
                                <x-icon name="delete" class="me-2" />
                                Deletar viagem
                            </button>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Nenhuma viagem cadastrada.</td>
        </tr>
        @endforelse
    </x-slot>
</x-table>



@foreach ($trips as $trip)
<x-custom-alert
    type="warning"
    :id="'confirmDeleteModal' . $trip->id"
    :message="'Tem certeza que deseja deletar a viagem ' . $trip->name . '?'"
    :showCancel="true"
    :confirmAction="route('trips.destroy', $trip)"
    confirmText="Deletar viagem"
    cancelText="Cancelar" />
@endforeach

@endsection