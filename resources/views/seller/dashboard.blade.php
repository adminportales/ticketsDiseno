@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
@endsection

@section('dashboard')
    <section class="row">
        <div class="col-12 col-lg-8">
            <div class="row">
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Tickets creados por mi</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalTickets }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Tickets creados por asistente</h6>
                                    <h6 class="font-extrabold mb-0">13</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Mis ultimos 5 tickets</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Info</th>
                                        <th>Elaboro</th>
                                        <th>Asignado a</th>
                                        <th class="text-center">Prioridad</th>
                                        <th>Hora de creación</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td> <br>
                                            <strong>Tipo: Virtual</strong> <br>
                                        </td>
                                        <td>

                                            <strong>Tecnica: Bordado Laser</strong>
                                            <br>

                                            <strong>Estado: Entregado</strong>
                                        </td>
                                        <td>Jaime Gonzalez</td>
                                        <td>Ived </td>
                                        <td>Alta</td>
                                        <td>2021-11-03 08:52:24 <br>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td> <br>
                                            <strong>Tipo: Presentación</strong> <br>
                                        </td>
                                        <td>

                                            <strong>Tecnica: Serigrafia</strong>
                                            <br>

                                            <strong>Estado: En proceso</strong>
                                        </td>
                                        <td>Jaime Gonzalez</td>
                                        <td>Aide </td>
                                        <td>Baja</td>
                                        <td>2021-11-03 08:52:24 <br>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td> <br>
                                            <strong>Tipo: Diseño especial</strong> <br>
                                        </td>
                                        <td>

                                            <strong>Tecnica: Tampografia</strong>
                                            <br>

                                            <strong>Estado: Creado</strong>
                                        </td>
                                        <td>Jaime Gonzalez</td>
                                        <td>Fernanda </td>
                                        <td>Media</td>
                                        <td>2021-11-03 08:52:24 <br>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header my-0 py-3">
                    <h4>Notificaciones Recientes</h4>
                </div>
                <div class="card-body">
                    <div class="">
                        <div class="border rounded p-1 my-1">
                            <h6 class="mb-1">Titulo</h6>
                            <p class="m-0">Nombre</p>
                            <p class="m-0"><strong>Mensaje:</strong>Lorem, ipsum dolor sit amet consectetur
                                adipisicing </p>
                            <div class="d-flex justify-content-around">
                                <a href="">Marcar como leido</a>
                                <a href="">Ver</a>
                            </div>
                        </div>
                        <div class="border rounded p-1 my-1">
                            <h6 class="mb-1">Titulo</h6>
                            <p class="m-0">Nombre</p>
                            <p class="m-0"><strong>Mensaje:</strong>Lorem, ipsum dolor sit amet consectetur
                                adipisicing </p>
                            <div class="d-flex justify-content-around">
                                <a href="">Marcar como leido</a>
                                <a href="">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
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
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script defer>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
