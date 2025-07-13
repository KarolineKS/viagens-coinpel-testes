@extends('layouts.app')

@section('action-type', 'offcanvas')
@section('action-target', '#vehicleFormOffcanvas')
@section('action-entity', 'veículo')

@section('search-placeholder', 'Pesquisar veículo')

@section('content')
<x-table>
    <x-slot name="head">
        <th>Prefixo</th>
        <th>Placa</th>
        <th>Modelo</th>
        <th>Chassi</th>
        <th>Tipo de Veículo</th>
        <th>Capacidade</th>
        <th>Ano</th>
        <th>Ações</th>
    </x-slot>

    <x-slot name="body">
        @forelse ($vehicles as $vehicle)
        <tr>
            <td>{{ $vehicle->prefix }}</td>
            <td>{{ $vehicle->license_plate }}</td>
            <td>{{ $vehicle->model }}</td>
            <td>{{ $vehicle->chassis }}</td>
            <td>{{ $vehicle->vehicle_type }}</td>
            <td>{{ $vehicle->capacity }}</td>
            <td>{{ $vehicle->year }}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-ghost" type="button" data-bs-toggle="dropdown">
                        <x-icon name="three-dots-vertical" />
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('vehicles.edit', $vehicle) }}">
                                <x-icon name="edit" class="me-2" />
                                Editar veículo
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item"
                                    onclick="return confirm('Tem certeza que deseja deletar este veículo?')">
                                    <x-icon name="delete" class="me-2" />
                                    Deletar veículo
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Nenhum veículo cadastrado.</td>
        </tr>
        @endforelse
    </x-slot>
</x-table>

@include('vehicles.partials.form-offcanvas', ['autoOpen' => isset($editVehicle)])

@endsection