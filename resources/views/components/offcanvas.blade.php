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
            <form method="POST" action="{{ $deleteRoute }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete"
                    onclick="return confirm('Tem certeza que deseja deletar este veículo?')">
                    <x-icon name="delete" />
                </button>
            </form>
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