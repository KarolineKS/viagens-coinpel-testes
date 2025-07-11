@extends('layouts.app')

@section('action-type', 'offcanvas')
@section('action-target', '#vehicleFormOffcanvas')
@section('action-entity', 'veículo')

@section('search-placeholder', 'Pesquisar veículo')

@section('content')
<div class="table-responsive">
    <table class="table table-custom">
        <thead>
            <tr>
                <th>Nome de Identificação</th>
                <th>Prefixo</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Chassi</th>
                <th>Tipo de Veículo</th>
                <th>Capacidade</th>
                <th>Ano</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle->identification_name }}</td>
                <td>{{ $vehicle->prefix}}</td>
                <td>{{ $vehicle->license_plate }}</td>
                <td>{{ $vehicle->model }}</td>
                <td>{{ $vehicle->chassis }}</td>
                <td>{{ $vehicle->vehicle_type }}</td>
                <td>{{ $vehicle->capacity }}</td>
                <td>{{ $vehicle->year }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <x-icon name="three-dots-vertical" />
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Editar veículo</a></li>
                            <li><a class="dropdown-item" href="#">Deletar veículo</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Nenhum veículo cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('vehicles.partials.form-offcanvas')
@endsection