@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
    @auth

    @endauth
@endsection

@section('dashboard')
    <section class="row">
        <div class="col-12 col-lg-8">
            <div class="d-flex justify-content-between">
                <div class="card">
                    <div class="card-body px-3 py-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Total de tickets</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalTickets }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border">
                    <div class="card-body px-3 py-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Tickets abiertos</h6>
                                <h6 class="font-extrabold mb-0">{{ $openTickets }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border">
                    <div class="card-body px-3 py-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon purple">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Tickets cerrados</h6>
                                <h6 class="font-extrabold mb-0">{{ $closedTickets }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <apex></apex>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body  px-3 py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="assets/images/faces/1.jpg" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h5>
                            <h6 class="text-muted mb-0">{{ auth()->user()->whatRoles[0]->display_name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Disponibilidad</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($users as $user)
                            <li class="list-group-item d-flex justify-content-between">
                                <p class="m-0">{{ $user->name . ' ' . $user->lastname }}</p>
                                <div>
                                    <change-status-designer :availability={{ $user->profile->availability }}
                                        :user={{ $user->id }}>
                                    </change-status-designer>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\vendors\toastify\toastify.css') }}">
    <style>
        table.dataTable td {
            padding: 15px 8px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets\vendors\toastify\toastify.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
