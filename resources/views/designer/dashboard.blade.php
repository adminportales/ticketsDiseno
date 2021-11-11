@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name }}</h3>
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
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Tickets asignados</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalTickets }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h4>Resumen de tickets</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Info</th>
                                        <th>Solicitado por</th>
                                        <th>Prioridad</th>
                                        <th>Hora de creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ticket->latestTicketInformation->title }} <br>
                                                <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                                            </td>
                                            <td>
                                                @if ($ticket->latestTicketInformation->techniqueTicket)
                                                    <strong>Tecnica:</strong>
                                                    {{ $ticket->latestTicketInformation->techniqueTicket->name }}<br>
                                                @endif
                                                <strong>Estado:</strong> {{ $ticket->latestStatusChangeTicket->status }}
                                            </td>
                                            <td>
                                                @if ($ticket->seller_id == $ticket->creator_id)
                                                    {{ $ticket->seller_name }}
                                                @else
                                                    {{ $ticket->creator_name }} <br>
                                                    <strong>Ejecutivo:</strong>{{ $ticket->seller_name }}
                                                @endif
                                            </td>
                                            <td>{{ $ticket->priorityTicket->priority }}</td>
                                            <td>{{ $ticket->latestTicketInformation->created_at }}
                                                {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                                            <td><a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}"
                                                    class="boton">Ver
                                                    ticket</a></td>
                                        </tr>
                                    @endforeach
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
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
