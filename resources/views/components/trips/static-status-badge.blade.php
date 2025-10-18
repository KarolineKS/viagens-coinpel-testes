@props(['status'])

@php
$statusClasses = [
'em_andamento' => 'bg-warning text-dark',
'concluida' => 'bg-success text-white',
'cancelada' => 'bg-danger text-white',
];

$statusTranslations = [
'em_andamento' => 'Em andamento',
'concluida' => 'Concluída',
'cancelada' => 'Cancelada',
];

$class = $statusClasses[$status] ?? 'bg-secondary text-white';
$text = $statusTranslations[$status] ?? $status;
@endphp

<span class="badge rounded-pill {{ $class }} static-status-badge">{{ $text }}</span>