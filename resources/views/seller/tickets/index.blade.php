@extends('layouts.app')

@section('title')
    <h3>Lista de Solicitudes</h3>
@endsection

@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Información general acerca de las solicitudes</h4>
            <a href="{{ route('tickets.create') }}" class="btn btn-success">Crear ticket</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="tableTickets">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Info</th>
                    @role('sales_manager|seller')
                        <th>Asignado a</th>
                    @endrole
                    @role('design_manager|designer')
                        <th>Creado por</th>
                    @endrole
                    @role('sales_manager')
                        <th class="text-center">Prioridad</th>
                    @endrole
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
                        <td><strong>Tecnica:</strong> {{ $ticket->latestTicketInformation->techniqueTicket->name }}<br>
                            <strong>Estado:</strong> {{ $ticket->latestStatusChangeTicket->status }}
                        </td>
                        @role('sales_manager|seller')
                            <td>{{ $ticket->designer_name }}</td>
                        @endrole
                        @role('design_manager|designer')
                            <td>{{ $ticket->seller_name }}</td>
                        @endrole
                        @role('sales_manager')
                            <td class="text-center">
                                <change-priority priority={{ $ticket->priorityTicket->priority }} :ticket={{ $ticket->id }}
                                    :priorities=@json($priorities)>
                                </change-priority>
                            </td>
                        @endrole
                        <td>{{ $ticket->latestTicketInformation->created_at }} <br>
                            {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                class="btn btn-warning btn-sm ">Ver</a>
                            <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                class="btn btn-primary btn-sm">Modificar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
