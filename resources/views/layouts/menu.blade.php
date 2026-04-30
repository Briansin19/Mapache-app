<div class="main-sidebar">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo.png') }}" width="65" alt="Infyom Logo">
        <a href="{{ url('/') }}"></a>
    </div>  

    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">MAPA ITCH</a>
        </div>
        
        <ul class="sidebar-menu">
            <li class="nav-item {{ Request::is('mapa*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('mapa.index') }}">
                    <i class="fas fa-map"></i><span>Mapa del Campus</span>
                </a>
            </li>

            @canany(['ver-usuario', 'ver-rol', 'ver-edificio', 'ver-habitaciones', 'ver-tipo_habitaciones', 'ver-personal', 'ver-horarios', 'ver-eventos'])
                <li class="menu-header">Administración</li>

                @can('ver-usuario')
                    <li class="nav-item dropdown {{ Request::is('usuarios*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Usuarios</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('usuarios.index') }}">Listar Usuarios</a></li>
                            <li><a class="nav-link" href="{{ route('usuarios.create') }}">Crear Usuario</a></li>
                        </ul>
                    </li>
                @endcan

                @can('ver-rol')
                    <li class="nav-item dropdown {{ Request::is('roles*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-tag"></i><span>Roles</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('roles.index') }}">Listar Roles</a></li>
                            <li><a class="nav-link" href="{{ route('roles.create') }}">Crear Rol</a></li>
                        </ul>
                    </li>
                @endcan

                @can('ver-edificio')
                    <li class="nav-item dropdown {{ Request::is('edificios*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-building"></i><span>Edificios</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('edificios.index') }}">Listar Edificios</a></li>
                            <li><a class="nav-link" href="{{ route('edificios.create') }}">Crear Edificio</a></li>
                        </ul>
                    </li>
                @endcan

                @can('ver-habitaciones')
                    <li class="nav-item dropdown {{ Request::is('habitaciones*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-bed"></i><span>Habitaciones</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('habitaciones.index') }}">Listar Habitaciones</a></li>
                            <li><a class="nav-link" href="{{ route('habitaciones.create') }}">Crear Habitación</a></li>
                        </ul>
                    </li>
                @endcan

                @can('ver-tipo_habitaciones')
                    <li class="nav-item dropdown {{ Request::is('tipos-habitaciones*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-list"></i><span>Tipos de Habitaciones</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('tipos-habitaciones.index') }}">Listar Tipos de Habitaciones</a></li>
                            <li><a class="nav-link" href="{{ route('tipos-habitaciones.create') }}">Crear Tipo de Habitación</a></li>
                        </ul>
                    </li>
                @endcan

                @can('ver-personal')
                    <li class="nav-item dropdown {{ Request::is('personal*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-tie"></i><span>Personal</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('personal.index') }}">Listar Personal</a></li>
                            <li><a class="nav-link" href="{{ route('personal.create') }}">Crear Personal</a></li>
                        </ul>
                    </li>
                @endcan

                @can('ver-horarios')
                    <li class="nav-item dropdown {{ Request::is('horarios_personal*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-clock"></i><span>Horarios del Personal</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('horarios_personal.index') }}">Listar Horarios</a></li>
                            <li><a class="nav-link" href="{{ route('horarios_personal.create') }}">Crear Horario</a></li>
                        </ul>
                    </li>
                @endcan

                @can('ver-eventos')
                    <li class="nav-item dropdown {{ Request::is('eventos*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar-alt"></i><span>Eventos</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('eventos.index') }}">Listar Eventos</a></li>
                            <li><a class="nav-link" href="{{ route('eventos.create') }}">Crear Evento</a></li>
                        </ul>
                    </li>
                @endcan
            @endcanany
        </ul>
    </aside>
</div>