@props([
'type' => 'success',
'title' => null,
'message',
'id' => 'sessionAlertModal',
'showCancel' => false,
'confirmAction' => null,
'confirmText' => 'Confirmar',
'cancelText' => 'Cancelar',
'method' => 'DELETE'
])

@php
$config = [
'error' => ['title' => 'Ocorreu um Erro', 'icon' => 'x-circle', 'buttonClass' => 'btn-danger'],
'danger' => ['title' => 'Confirmar Ação', 'icon' => 'exclamation-triangle','buttonClass' => 'btn-danger'],
'warning' => ['title' => 'Atenção!', 'icon' => 'exclamation-triangle','buttonClass' => 'btn-warning'],
'info' => ['title' => 'Informação', 'icon' => 'info-circle', 'buttonClass' => 'btn-info'],
'success' => ['title' => 'Sucesso!', 'icon' => 'check-circle', 'buttonClass' => 'btn-success'],
];

$alertTitle = $title ?? ($config[$type]['title'] ?? '');
$iconName = $config[$type]['icon'] ?? '';
$buttonClass = $config[$type]['buttonClass'] ?? 'btn-primary';

@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-alert-content custom-alert-content--{{ $type }}" role="alertdialog" aria-labelledby="{{ $id }}Title" aria-describedby="{{ $id }}Message">
            <div class="modal-body custom-alert-body">
                <div class="custom-alert-header" aria-hidden="true">
                    <div class="icon-wrapper">
                        <x-icon :name="$iconName" />
                    </div>
                </div>
                <h2 class="custom-alert-title" id="{{ $id }}Title">{{ $alertTitle }}</h2>
                <p class="custom-alert-message" id="{{ $id }}Message">{!! $message !!}</p>

                @if($showCancel)
                <div class="custom-alert-actions">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ $cancelText }}
                    </button>
                    @if($confirmAction)
                    <form method="POST" action="{{ $confirmAction }}" class="d-inline">
                        @csrf
                        @method($method)
                        <button type="submit" class="btn btn-confirm-variant">
                            {{ $confirmText }}
                        </button>
                    </form>
                    @endif
                </div>
                @else
                <div class="custom-alert-actions">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        OK
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>