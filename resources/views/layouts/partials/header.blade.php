<header class="header d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center header__actions">
        <a href="@yield('action-link', '#')" class="btn btn-primary d-flex align-items-center gap-2 header__add-btn">
            <span>+</span>
            <span>@yield('action-text', 'Adicionar')</span>
        </a>

        <button class="btn header__filter-btn">
            Filtrar
        </button>


    </div>

    <div class="header__user-menu d-flex align-items-center">

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
                    <a class="dropdown-item d-flex align-items-center gap-2" href="#">
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