@props([
'name' => 'state',
'value' => '',
'class' => 'form-group__input',
'required' => false
])

@php
$states = [
'AC' => 'Acre',
'AL' => 'Alagoas',
'AP' => 'Amapá',
'AM' => 'Amazonas',
'BA' => 'Bahia',
'CE' => 'Ceará',
'DF' => 'Distrito Federal',
'ES' => 'Espírito Santo',
'GO' => 'Goiás',
'MA' => 'Maranhão',
'MT' => 'Mato Grosso',
'MS' => 'Mato Grosso do Sul',
'MG' => 'Minas Gerais',
'PA' => 'Pará',
'PB' => 'Paraíba',
'PR' => 'Paraná',
'PE' => 'Pernambuco',
'PI' => 'Piauí',
'RJ' => 'Rio de Janeiro',
'RN' => 'Rio Grande do Norte',
'RS' => 'Rio Grande do Sul',
'RO' => 'Rondônia',
'RR' => 'Roraima',
'SC' => 'Santa Catarina',
'SP' => 'São Paulo',
'SE' => 'Sergipe',
'TO' => 'Tocantins'
];
@endphp

<select
    class="{{ $class }} @error($name) is-invalid @enderror"
    id="{{ $name }}"
    name="{{ $name }}"
    {{ $required ? 'required' : '' }}>
    <option value="">Selecione...</option>
    @foreach($states as $key => $state)
    <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
        {{ $state }}
    </option>
    @endforeach
</select>

@error($name)
<span class="text-danger small d-block mt-1">
    <x-icon name="exclamation-triangle" class="me-1" style="font-size: 12px;" />
    {{ $message }}
</span>
@enderror