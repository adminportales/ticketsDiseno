<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"
                            srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                @role('seller')
                    <li class="sidebar-item  active">
                        <a href="{{ route('home') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
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
                    <li class="sidebar-item dropdown">
                        <a id="navbarDropdown" class="sidebar-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="bi bi-grid-fill"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
