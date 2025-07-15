@props([
'title',
'sectionId',
'driver' => null
])

<div class="section-header mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h6 class="text-muted">{{ $title }}</h6>

        @if($driver)
        <button type="button" class="btn btn-link text-primary p-0" data-action="edit-section" data-section="{{ $sectionId }}">
            <x-icon name="edit" />
        </button>
        @endif
    </div>
</div>

@if($driver)
<div id="{{ $sectionId }}ViewMode">
    {{ $viewMode }}
</div>


<div id="{{ $sectionId }}EditMode" class="d-none">
    {{ $editMode }}
    <div class="form-group">
        <button type="button" class="btn btn-sm btn-success me-2" data-action="save-section" data-section="{{ $sectionId }}">Salvar</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-action="cancel-edit" data-section="{{ $sectionId }}">Cancelar</button>
    </div>
</div>
@else

<div>
    {{ $createMode }}
</div>
@endif