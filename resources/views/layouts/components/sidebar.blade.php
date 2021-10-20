<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/logo/BH.jpg') }}" alt="Logo" srcset="">
                        <img src="{{ asset('assets/images/logo/PL.jpg') }}" alt="Logo" srcset="">
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @role('admin')
                    <li class="sidebar-item  ">
                        <a href="{{ route('users.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver Usuarios</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="{{ route('users.create') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Crear nuevo usuario</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="{{ Request::root() . '/roles_assignment' }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Asignar Permisos</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="{{ route('reporte_tickets') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Reporte de tickets</span>
                        </a>
                    </li>
                @endrole
                @role('seller')
                    <li class="sidebar-item  ">
                        <a href="{{ route('tickets.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver Tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="{{ route('tickets.create') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Crear ticket</span>
                        </a>
                    </li>
                @endrole
                @role('designer')
                    <li class="sidebar-item  ">
                        <a href="{{ route('designer.inicio') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver tickets</span>
                        </a>
                    </li>
                @endrole
                @role('design_manager')
                    <li class="sidebar-item  ">
                        <a href="{{ route('design_manager.inicio') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="{{ route('design_manager.tickets') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Mis tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="{{ route('design_manager.assign') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Asignar tickets</span>
                        </a>
                    </li>
                @endrole
                @role('sales_manager')
                    <li class="sidebar-item  {{ request()->is('seller/tickets') ? 'active' : '' }}">
                        <a href="{{ route('sales_manager.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Mis Tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->is('seller/tickets') ? 'active' : '' }}">
                        <a href="{{ route('sales_manager.all') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver Tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->is('seller/tickets/create') ? 'active' : '' }} ">
                        <a href="{{ route('sales_manager.create') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Crear ticket</span>
                        </a>
                    </li>
                @endrole
                @role('designer')
                    <li class="sidebar-item  ">
                        <a href="{{ route('designer.inicio') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver tickets</span>
                        </a>
                    </li>
                @endrole

                <!-- Authentication Links -->
                @guest
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="sidebar-item  has-sub">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-stack"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="submenu ">
                            <li class="submenu-item ">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
