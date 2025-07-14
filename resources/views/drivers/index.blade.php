@extends('layouts.app')

@section('action-type', 'offcanvas')
@section('action-target', '#driverFormOffcanvas')
@section('action-entity', 'motorista')

@section('search-action', route('drivers.index'))
@section('search-placeholder', 'Pesquisar motorista')

@section('content')
<div class="row">

    @forelse ($drivers as $driver)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card driver-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">

                        @if($driver->profile_photo_url)
                        <img src="{{ $driver->profile_photo_url }}"
                            alt="{{ $driver->name }}"
                            class="driver-avatar me-3">

                        @else
                        <div class="driver-avatar driver-avatar-placeholder me-3">
                            {{ $driver->initials }}
                        </div>

                        @endif
                        <div class="driver-info">
                            <h6 class="driver-name">{{ $driver->name }}</h6>
                            <p class="driver-email mb-0">{{ $driver->email }}</p>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-ghost" type="button" data-bs-toggle="dropdown">
                            <x-icon name="three-dots-vertical" />
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('drivers.edit', $driver) }}">
                                    <x-icon name="edit" class="me-2" />
                                    Editar motorista
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal{{ $driver->id }}">
                                    <x-icon name="delete" class="me-2" />
                                    Deletar motorista
                                </button>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 drivers-empty-state">
        <div class="text-center">
            <x-icon name="users" class="text-muted mb-3" style="font-size: 3rem;" />
            <h5>Nenhum motorista encontrado</h5>
            <p>Comece cadastrando o primeiro motorista.</p>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#driverFormOffcanvas">
                <x-icon name="plus" class="me-2" />
                Adicionar motorista
            </button>
        </div>
    </div>
    @endforelse
</div>

@if($drivers->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $drivers->links() }}
</div>
@endif

@include('drivers.partials.form-offcanvas', ['autoOpen' => isset($editDriver)])

@foreach ($drivers as $driver)
<x-custom-alert
    type="warning"
    :id="'confirmDeleteModal' . $driver->id"
    :message="'Tem certeza que deseja deletar o motorista ' . $driver->name . ' (' . $driver->email . ')?'"
    :showCancel="true"
    :confirmAction="route('drivers.destroy', $driver)"
    confirmText="Deletar motorista"
    cancelText="Cancelar" />
@endforeach

@endsection