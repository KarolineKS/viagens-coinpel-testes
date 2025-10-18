@extends('layouts.app')

@section('title', 'Editar Viagem')
@section('hide_header_search', true)

@section('header-actions')
<div class="d-flex align-items-center header__actions">
    <a href="{{ route('trips.index') }}" class="btn header__filter-btn d-flex align-items-center gap-2">
        Voltar
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid mt-0">
    <div class="row mt-0 p-0">
        <div class="col-12 mt-0 p-0">
            <div class="form-container">
                <form action="{{ route('trips.update', $trip->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('trips.partials._form')

                    <div class="d-flex justify-content-start gap-3 pt-3 form-actions">
                        <button type="submit" class="btn btn-custom-primary">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                            Salvar alterações
                        </button>
                        <a href="{{ route('trips.index') }}" class="btn btn-custom-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('show_validation_error_alert'))
<x-custom-alert
    type="error"
    :title="session('validation_error_title')"
    :message="session('validation_error_message')"
    id="validationErrorAlert" />
@endif
@endsection

@push('scripts')
@if (session('show_validation_error_alert'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var validationErrorModal = new bootstrap.Modal(document.getElementById('validationErrorAlert'));
        validationErrorModal.show();
    });
</script>
@endif
@endpush