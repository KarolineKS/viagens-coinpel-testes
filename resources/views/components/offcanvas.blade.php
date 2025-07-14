@props([
'id',
'title' => '',
'autoOpen' => false,
'showDeleteBtn' => false,
'deleteRoute' => null,
'isEdit' => false,
])

<div class="offcanvas offcanvas-end" tabindex="-1" id="{{ $id }}" aria-labelledby="{{ $id }}Label"
    @if($autoOpen) data-auto-open="true" @endif>
    <div class="offcanvas-header">

        <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
            <x-icon name="x" />
        </button>

        <h5 class="offcanvas-title {{ !$isEdit ? 'text-center flex-grow-1' : '' }}" id="{{ $id }}Label">{{ $title }}</h5>

        @if($showDeleteBtn && $deleteRoute)
        <div class="offcanvas-header-actions">
            <button type="button" class="btn-delete"
                data-bs-toggle="modal"
                data-bs-target="#confirmDeleteOffcanvasModal">
                <x-icon name="delete" />
            </button>
        </div>
        @endif
    </div>

    @if(isset($body))
    <div class="offcanvas-body">
        {{ $body }}
    </div>
    @endif

    @if(isset($footer))
    <div class="offcanvas-footer">
        {{ $footer }}
    </div>
    @endif
</div>