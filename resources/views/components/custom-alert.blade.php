@props([
'type' => 'success',
'message',
'id' => 'sessionAlertModal',
'showCancel' => false,
'confirmAction' => null,
'confirmText' => 'Confirmar',
'cancelText' => 'Cancelar'
])

@php
$config = [
'error' => [
'title' => 'Ocorreu um Erro',
'icon' => 'x-circle',
],
'warning' => [
'title' => 'Atenção!',
'icon' => 'exclamation-triangle',
],
'info' => [
'title' => 'Informação',
'icon' => 'info-circle',
],
'success' => [
'title' => 'Sucesso!',
'icon' => 'check-circle',
],
];

$title = $config[$type]['title'] ?? '';
$iconName = $config[$type]['icon'] ?? '';

@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-alert-content custom-alert-content--{{ $type }}">
            <div class="custom-alert-header">
                <x-icon :name="$iconName" />
            </div>
            <div class="modal-body custom-alert-body">
                <h2 class="custom-alert-title">{{ $title }}</h2>
                <p class="custom-alert-message">{{ $message }}</p>

                @if($showCancel && $confirmAction)
                <!-- Modo confirmação com dois botões -->
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ $cancelText }}
                    </button>
                    <form method="POST" action="{{ $confirmAction }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            {{ $confirmText }}
                        </button>
                    </form>
                </div>
                @else
                <!-- Modo alerta simples com um botão -->
                <button type="button" class="btn btn-primary custom-alert-button" data-bs-dismiss="modal">OK</button>
                @endif
            </div>
        </div>
    </div>
</div>