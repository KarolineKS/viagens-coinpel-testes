@extends('layouts.app')

@section('title', 'Adicionar Viagem')
@section('hide_header_search', true)

@section('header-actions')
<div class="d-flex align-items-center header__actions">
    <a href="{{ route('trips.index') }}" class="btn header__filter-btn d-flex align-items-center gap-2">
        <x-icon name="arrow-left" />
        <span>Voltar</span>
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid mt-0">
    <div class="row mt-0 p-0">
        <div class="col-12 mt-0 p-0">

            <div class="form-container">
                <form action="{{ route('trips.store') }}" method="POST">
                    @csrf
                    @include('trips.partials._form')


                    <div class="d-flex justify-content-start gap-3 pt-3 form-actions">

                        <button type="submit" class="btn btn-custom-primary">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"></span>
                            Salvar viagem
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