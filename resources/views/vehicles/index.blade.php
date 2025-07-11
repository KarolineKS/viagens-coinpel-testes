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
                <x-actions-dropdown
                    :actions="[
                        ['url' => '#', 'label' => 'Editar veículo', 'icon' => 'edit'],
                        ['url' => '#', 'label' => 'Deletar veículo', 'icon' => 'delete']
                    ]" />
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">Nenhum veículo cadastrado.</td>
        </tr>
        @endforelse
    </x-slot>
</x-table>

@include('vehicles.partials.form-offcanvas')
@endsection