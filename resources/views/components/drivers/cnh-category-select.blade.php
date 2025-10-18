@props([
'name' => 'cnh_category',
'value' => '',
'class' => 'form-group__input',
'required' => false
])

@php
$categories = [
'A' => 'Categoria A',
'B' => 'Categoria B',
'C' => 'Categoria C',
'D' => 'Categoria D',
'E' => 'Categoria E',
'AB' => 'Categoria AB',
'AC' => 'Categoria AC',
'AD' => 'Categoria AD',
'AE' => 'Categoria AE'
];
@endphp

<select
    class="{{ $class }} @error($name) is-invalid @enderror"
    id="{{ $name }}"
    name="{{ $name }}"
    {{ $required ? 'required' : '' }}>
    <option value="">Selecione...</option>

    @foreach($categories as $key => $category)
    <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
        {{ $category }}
    </option>
    @endforeach
</select>

@error($name)
<span class="text-danger small d-block mt-1">
    <x-icon name="exclamation-triangle" class="me-1" style="font-size: 12px;" />
    {{ $message }}
</span>
@enderror