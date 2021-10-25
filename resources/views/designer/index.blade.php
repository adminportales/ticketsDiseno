@extends('layouts.app')

@section('title')
    <h3>Lista de Tickets Asignados</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general acerca de las solicitudes que tienes asignadas</h4>
    </div>

    <div class="card-body">
        <table class="table" id="tableTickets">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Info</th>
                    <th>Elaboro</th>
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
                        <td><strong>Tecnica:</strong> {{ $ticket->latestTicketInformation->techniqueTicket->name }}<br>
                            <strong>Estado:</strong> {{ $ticket->latestTicketInformation->statusTicket->status }}
                        </td>
                        <td>{{ $ticket->seller_name }}</td>
                        <td>{{ $ticket->priorityTicket->priority }}</td>
                        <td>{{ $ticket->latestTicketInformation->created_at }}
                            {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                        <td><a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}" class="btn btn-warning">Ver
                                ticket</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

    @section('styles')
        <link rel="stylesheet"
            href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
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
