@extends('layouts.app')

@section('header-button')
<button class="btn btn-primary">
    <x-icon name="plus" />
    <span>Adicionar veículo</span>
</button>
@endsection

@section('search-placeholder', 'Pesquisar veículo')

@section('content')
<div class="table-responsive">
    <table class="table table-custom">
        <thead>
            <tr>
                <th>Prefixo</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Chassi</th>
                <th>Tipo de veículo</th>
                <th>Capacidade</th>
                <th>Ano</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle->prefixo }}</td>
                <td>{{ $vehicle->placa }}</td>
                <td>{{ $vehicle->modelo }}</td>
                <td>{{ $vehicle->chassi }}</td>
                <td>{{ $vehicle->tipo_veiculo }}</td>
                <td>{{ $vehicle->capacidade }}</td>
                <td>{{ $vehicle->ano }}</td>
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
@endsection