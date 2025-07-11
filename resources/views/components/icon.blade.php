@props([
'name',
'class' => '',
])

@php
$iconPath = public_path('images/icons/' . $name . '.svg');
$svgContent = '';

if (file_exists($iconPath)) {
$svgContent = file_get_contents($iconPath);
}
@endphp

@if ($svgContent)
<div {{ $attributes->merge(['class' => 'icon-wrapper ' . $class]) }}>
    {!! $svgContent !!}
</div>
@endif