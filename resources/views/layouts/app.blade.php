<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\vendors\toastify\toastify.css') }}">
    @yield('styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div id="app">
        @include('layouts.components.sidebar')
        <div id="main" class="py-3">
            {{-- Menu Hamburguesa --}}
            <header class="mb-3 d-xl-none">
                <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading ">
                <div id="appVue">
                    <notify :user={{ auth()->user()->id }}></notify>
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 order-md-1 order-last d-flex justify-content-between align-items-center">
                                @yield('title')
                                <div class="card m-0 p-1">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xl">
                                            <div class="card-photo">
                                                @if (auth()->user()->profile->photo)
                                                    <img src="{{ asset('storage\profiles') . '/' . auth()->user()->profile->photo }}"
                                                        class="width-icon" alt="">
                                                @else
                                                    <p
                                                        class="rounded-circle border border-primary m-0 d-flex justify-content-center align-items-center width-icon">
                                                        <span>{{ substr(auth()->user()->name, 0, 1) . substr(auth()->user()->lastname, 0, 1) }}</span>
                                                    </p>
                                                @endif
                                                <change-photo></change-photo>
                                            </div>
                                        </div>
                                        <div class="ms-3 name">
                                            <h5 class="font-bold">
                                                {{ auth()->user()->name . ' ' . auth()->user()->lastname }}
                                            </h5>
                                            <p class="text-muted mb-0">
                                                {{ auth()->user()->whatRoles[0]->display_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        @yield('dashboard')
                        <div class="card">
                            @yield('content')
                        </div>
                    </section>
                </div>
            </div>
            @include('layouts.components.footer')
        </div>
    </div>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('assets\vendors\toastify\toastify.js') }}"></script>
    <script src="{{ asset('assets/js/mazer.js') }}"></script>
</body>

</html>
