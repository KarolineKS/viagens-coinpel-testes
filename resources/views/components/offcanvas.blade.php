@props([
'id',
'title' => '',
])

<div class="offcanvas offcanvas-end" tabindex="-1" id="{{ $id }}" aria-labelledby="{{ $id }}Label">
    <div class="offcanvas-header">

        <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
            <x-icon name="x" />
        </button>

        <h5 class="offcanvas-title" id="{{ $id }}Label">{{ $title }}</h5>

        <div class="offcanvas-header-actions">
            <button type="button" class="btn-delete" id="deleteVehicleBtn">
                <x-icon name="delete" />
            </button>
        </div>
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