<header class="header d-flex justify-content-between align-items-center">

    @section('header-actions')
    <div class="d-flex align-items-center header__actions">
        @php
        $actionType = View::getSection('action-type', 'link');
        $actionTarget = View::getSection('action-target', '#');
        $actionEntity = View::getSection('action-entity', '');
        @endphp

        @if ($actionType === 'modal' || $actionType === 'offcanvas')
        <button class="btn btn-primary d-flex align-items-center gap-2 header__add-btn"
            data-bs-toggle="{{ $actionType }}" data-bs-target="{{ $actionTarget }}">
            <x-icon name="plus" />
            <span>Adicionar {{ $actionEntity }}</span>
        </button>
        @else
        <a href="{{ $actionTarget }}" class="btn btn-primary d-flex align-items-center gap-2 header__add-btn">
            <x-icon name="plus" />
            <span>Adicionar {{ $actionEntity }}</span>
        </a>
        @endif

        <button class="btn header__filter-btn">
            Filtrar
        </button>
    </div>
    @show

    <div class="header__user-menu d-flex align-items-center">

        @unless(View::hasSection('hide_header_search'))
        <form action="@yield('search-action', '#')" method="GET" class="header__search">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="@yield('search-placeholder', 'Pesquisar...')">
                <button class="btn" type="submit">
                    <x-icon name="search" />
                </button>
            </div>
        </form>

        <div class="header__notifications">
            <button class="btn btn-icon">
                <x-icon name="bell" />
            </button>
        </div>
        @endunless

        <div class="dropdown">
            <button class="header__user-info d-flex align-items-center" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10">
                <div class="header__user-avatar">
                    <img src="https://i.pravatar.cc/40?u={{ Auth::user()->id }}" alt="{{ Auth::user()->name }}">
                </div>
                <div class="header__user-details d-flex flex-column text-start">
                    <span class="header__user-name">{{ Auth::user()->name }}</span>
                    <span class="header__user-role">Administrador</span>
                </div>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                <div class="dropdown-content-wrapper">
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('users.index') }}">
                        <x-icon name="users" />
                        <span>Usuários</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                            <x-icon name="logout" />
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>