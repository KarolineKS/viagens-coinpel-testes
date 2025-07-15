@php
$isEdit = isset($editDriver) && $editDriver;
@endphp

<x-offcanvas id="driverFormOffcanvas"
    title="{{ $isEdit ? 'Editar Motorista' : 'Cadastrar Motorista' }}"
    data-drivers-index-url="{{ route('drivers.index') }}">

    <x-slot name="body">
        <div id="driver-form-container">
            @include('drivers.partials._form', ['editDriver' => $isEdit ? $editDriver : null])
        </div>
    </x-slot>

    <x-slot name="footer">
        @if($isEdit)
        {{-- Footer for Edit Mode --}}
        <div id="edit-mode-footer" class="w-100">
            <button type="submit" class="btn btn-primary w-100 mb-2" form="driverForm">Salvar Alterações</button>
            <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
        </div>

        @else
        {{-- Footer for Create Mode --}}
        <div id="create-mode-footer" class="w-100">
            <button type="submit" class="btn btn-primary w-100 mb-2" form="driverForm">Finalizar Cadastro</button>
            <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
        </div>
        @endif
    </x-slot>
</x-offcanvas>