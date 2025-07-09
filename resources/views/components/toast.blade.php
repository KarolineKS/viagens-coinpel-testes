@props(['type' => 'success', 'message'])

@php
$config = [
'success' => [
'title' => 'Sucesso!',
],
];

$title = $config[$type]['title'];
@endphp

<div class="toast toast-{{ $type }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
    <div class="toast-header">
        <x-icon type="toast-success" />
        <strong class="me-auto">{{ $title }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ $message }}
    </div>
</div>