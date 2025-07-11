<aside class="sidebar">
    <div class="sidebar__header">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-coinpel-branca.svg') }}" alt="Coinpel Logo" class="sidebar__logo">
        </a>
    </div>

    <nav class="sidebar__nav">
        <ul>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="icon-users" class="sidebar__icon" />
                    <span>Usuários</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="icon-motorista" class="sidebar__icon" />
                    <span>Motoristas</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="icon-grafh" class="sidebar__icon" />
                    <span>Estatísticas</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="icon-bus" class="sidebar__icon" />
                    <span>Veículos</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="icon-viagens" class="sidebar__icon" />
                    <span>Viagens</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="icon-contract" class="sidebar__icon" />
                    <span>Contratos</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="icon-wallet" class="sidebar__icon" />
                    <span>Pacotes</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>