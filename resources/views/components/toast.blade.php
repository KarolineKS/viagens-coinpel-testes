@props(['type' => 'success', 'message'])

@php
$config = [
'success' => [
'title' => 'Sucesso!',
'icon' => 'toast-success',
],
];

$title = $config[$type]['title'] ?? '';
$iconName = $config[$type]['icon'] ?? '';

@endphp

<div class="toast toast-{{ $type }}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
    <div class="toast-header">
        <x-icon :name="$iconName" class="toast-icon" />
        <strong class="me-auto">{{ $title }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        {{ $message }}
    </div>
</div>