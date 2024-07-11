<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="toggler">
            <a href="#" class="sidebar-hide d-xl-none d-flex justify-content-end px-5" style="font-size: 2rem"><i
                    class="bi bi-x bi-middle"></i></a>
        </div>
        <div class="sidebar-header px-3 pt-4 pb-1">
            <div class="name text-center">

                <div class="d-flex align-items-center flex-column">
                    <div class="w-50">
                        <img src="{{ asset('img\logos\tickets.png') }}" alt="" class="w-100 h-auto">
                    </div>
                    <h4 class="font-bold" style="color: white">
                        T-DESIGN
                    </h4>
                </div>
                <hr>
                <h5 class="font-bold" style="color: white">
                    {{ auth()->user()->name . ' ' . auth()->user()->lastname }}
                </h5>
                <h6 class="text-muted mb-0">
                    {{ Auth::user()->roles[0]->display_name }}
                </h6>
            </div>
            <hr>
        </div>
        <div class="sidebar-menu">
            <ul class="menu px-3">
                <li class="sidebar-title">Menu</li>
                <li class="sidebar-item {{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @role('admin')
                    <li class="sidebar-item  {{ request()->is('users') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver Usuarios</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('viewChanges') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Historial de Diseño</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->is('teams') ? 'active' : '' }}">
                        <a href="{{ route('teams.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver Equipos</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->is('ticketsViewAll') ? 'active' : '' }}">
                        <a href="{{ route('admin.verTickets') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Todos los Tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->is('ticketsViewAll') ? 'active' : '' }}">
                        <a href="{{ route('admin.encuestas') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Encuestas</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{-- {{ request()->is('teamsdiseno') ? 'active' : '' }} --}}">
                        <a href="{{ route('teamsdiseno.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver Equipos de diseño</span>
                        </a>
                    </li>
                @endrole
                @permission('create-ticket')
                    <li class="sidebar-item {{ request()->is('tickets*') ? 'active' : '' }}">
                        <a href="{{ route('tickets.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver Tickets</span>
                        </a>
                    </li>
                @endpermission
                @role('designer')
                    <li class="sidebar-item {{ request()->is('designer/home') ? 'active' : '' }}">
                        <a href="{{ route('designer.inicio') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver ticket</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('designer/list-wait') ? 'active' : '' }}">
                        <a href="{{ route('designer.listWait') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Lista de Espera</span>
                        </a>
                    </li>
                @endrole
                @role('design_manager')
                    <li class="sidebar-item  {{ request()->is('design_manager/mis-tickets') ? 'active' : '' }}">
                        <a href="{{ route('design_manager.tickets') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Mis tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->is('design_manager/all-tickets') ? 'active' : '' }}">
                        <a href="{{ route('design_manager.all') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Ver tickets</span>
                        </a>
                    </li>
                    <li class="sidebar-item  {{ request()->is('design_manager/assign-ticket') ? 'active' : '' }}">
                        <a href="{{ route('design_manager.assign') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Mi equipo</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('designer/list-wait') ? 'active' : '' }}">
                        <a href="{{ route('designer.listWait') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Lista de Espera</span>
                        </a>
                    </li>
                @endrole
                @role('sales_manager')
                    {{-- <li class="sidebar-item  {{ request()->is('sales_manager/tickets') ? 'active' : '' }}">
                        <a href="{{ route('sales_manager.index') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Mis Tickets</span>
                        </a>
                    </li> --}}
                    <li class="sidebar-item  {{ request()->is('sales_manager/all-tickets') ? 'active' : '' }}">
                        <a href="{{ route('sales_manager.all') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Todos los Tickets</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
