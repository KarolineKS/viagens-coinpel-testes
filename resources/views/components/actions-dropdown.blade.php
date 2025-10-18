@props(['actions' => []])

<div class="dropdown">
    <button class="btn btn-ghost" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-container="body">
        <x-icon name="three-dots-vertical" />
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach ($actions as $action)
        <li>
            <a class="dropdown-item" href="{{ $action['url'] }}">
                <x-icon :name="$action['icon']" class="me-2" />
                {{ $action['label'] }}
            </a>
        </li>
        @endforeach
    </ul>
</div>