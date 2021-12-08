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
                                    <h6 class="text-muted font-semibold">Usuarios activos</h6>
                                    <h6 class="font-extrabold mb-0">{{count ($user)}}</h6>
                                </div>
                            </div>
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
    {{-- <div class="card-header">
        <h4 class="card-title">Información general</h4>


        <div class="d-flex justify-content-between p-3">
            <div> Total de tickets:<b>{{ $totalTickets }}</b></div>
            <div> Total de tickets abiertos:<b>{{ $openTickets }}</b></div>
            <div> Total de tickets cerrados:<b>{{ $closedTickets }}</b></div>
        </div>

        <div class="card-body">
            <table class="table" id="tableTickets">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Categoria de Ticket</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ticket->latestTicketInformation->title }}</td>
                            <td>{{ $ticket->typeTicket->type }}</td>
                            <td>{{ $ticket->priorityTicket->priority }}</td>
                            <td>{{ $ticket->latestStatusChangeTicket->status }}</td>
                            <td>{{ $ticket->latestTicketInformation->created_at }}
                                {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                            <td><a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}"
                                    class="boton-ver">Ver
                                    ticket</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
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
