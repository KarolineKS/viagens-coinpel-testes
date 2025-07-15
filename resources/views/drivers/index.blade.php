@extends('layouts.app')

@section('action-type', 'link')
@section('action-target', route('drivers.create'))
@section('action-entity', 'motorista')

@section('search-action', route('drivers.index'))
@section('search-placeholder', 'Pesquisar motorista')

@section('content')
<div class="row drivers-listing g-3">

    @forelse ($drivers as $driver)
    <div class="col-md-6 col-lg-4">
        <div class="card driver-card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">

                        @if($driver->profile_photo_url)
                        <img src="{{ $driver->profile_photo_url }}"
                            alt="{{ $driver->name }}"
                            class="driver-avatar me-4">

                        @else
                        <div class="driver-avatar driver-avatar-placeholder me-4">
                            {{ $driver->initials }}
                        </div>

                        @endif
                        <div class="driver-info">
                            <h6 class="driver-name">{{ $driver->name }}</h6>
                            <p class="driver-email mb-1">{{ $driver->email }}</p>
                            <div class="d-flex align-items-center justify-content-between">

                                @if($driver->isCnhExpired())
                                <span class="badge bg-danger">CNH Vencida</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-ghost p-0" type="button" data-bs-toggle="dropdown">
                            <x-icon name="three-dots-vertical" class="driver-actions-icon" />
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('drivers.index', ['edit' => $driver->id]) }}" class="dropdown-item">
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
            <a href="{{ route('drivers.create') }}" class="btn btn-primary">
                <x-icon name="plus" class="me-2" />
                Adicionar motorista
            </a>
        </div>
    </div>
    @endforelse
</div>

@if($drivers->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $drivers->links() }}
</div>
@endif

@include('drivers.partials.form-offcanvas', ['autoOpen' => isset($editDriver), 'editDriver' => $editDriver ?? null])

@if(isset($editDriver) || request()->has('create'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('driverFormOffcanvas'));
        offcanvas.show();
    });
</script>
@endif

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