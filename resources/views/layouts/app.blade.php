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

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    @yield('styles')
</head>

<body>
    <div id="app">
        @include('layouts.components.sidebar')
        <div id="main">
            {{-- Menu Hamburguesa --}}
            <header class="mb-3 d-xl-none">
                <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading ">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            @yield('title')
                            {{-- <h3>Layout Default</h3> --}}
                            {{-- <p class="text-subtitle text-muted">The default layout </p> --}}
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        @yield('content')
                        {{-- <div class="card-header">
                            <h4 class="card-title">Default Layout</h4>
                        </div>
                        <div class="card-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, commodi? Ullam quaerat
                            similique iusto
                            temporibus, vero aliquam praesentium, odit deserunt eaque nihil saepe hic deleniti? Placeat
                            delectus
                            quibusdam ratione ullam!
                        </div> --}}
                    </div>
                </section>
            </div>
            @include('layouts.components.footer')
        </div>
    </div>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('assets/js/mazer.js') }}"></script>
</body>

</html>
