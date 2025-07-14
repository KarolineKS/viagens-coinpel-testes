@props([
'name',
'label',
'type' => 'text',
'value' => '',
'required' => false,
'options' => null, // Para selects
'placeholder' => null,
'accept' => null, // Para file inputs
'class' => null
])

<div class="form-group">
    <label for="{{ $name }}" class="form-group__label">{{ $label }}</label>

    @if($type === 'select')
    <select
        class="form-group__input @error($name) is-invalid @enderror {{ $class }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}>

        @if($placeholder)
        <option value="">{{ $placeholder }}</option>
        @endif

        @if($options)
        @foreach($options as $key => $option)
        <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
            {{ $option }}
        </option>
        @endforeach

        @endif
    </select>

    @elseif($type === 'file')
    <input
        type="file"
        class="form-group__input @error($name) is-invalid @enderror {{ $class }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $accept ? "accept={$accept}" : '' }}
        {{ $required ? 'required' : '' }}>

    @else
    <input
        type="{{ $type }}"
        class="form-group__input @error($name) is-invalid @enderror {{ $class }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}>
    @endif

    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>