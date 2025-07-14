<aside class="sidebar">
    <div class="sidebar__header">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo-coinpel-branca.svg') }}" alt="Coinpel Logo" class="sidebar__logo">
        </a>
    </div>

    <nav class="sidebar__nav">
        <ul>
            <li class="sidebar__item">
                <a href="{{ route('users.index') }}" class="sidebar__link">
                    <x-icon name="clientes" class="sidebar__icon" />
                    <span>Usuários</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="{{ route('drivers.index') }}" class="sidebar__link">
                    <x-icon name="motorista" class="sidebar__icon" />
                    <span>Motoristas</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="estatisticas" class="sidebar__icon" />
                    <span>Estatísticas</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="{{ route('vehicles.index') }}" class="sidebar__link">
                    <x-icon name="veiculos" class="sidebar__icon" />
                    <span>Veículos</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="viagens" class="sidebar__icon" />
                    <span>Viagens</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="contratos" class="sidebar__icon" />
                    <span>Contratos</span>
                </a>
            </li>
            <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <x-icon name="pacotes" class="sidebar__icon" />
                    <span>Pacotes</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>