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
                    <th>Categoria de Ticket</th>
                    <th>Estatus</th>
                    <th>Hora de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->latestTicketInformation->title }}</td>
                        <td>{{ $ticket->typeTicket->type }}</td>
                        <td>{{ $ticket->latestTicketInformation->statusTicket->status }}</td>
                        <td>{{ $ticket->latestTicketInformation->created_at }}
                            {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                        <td class="text-center"><a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                class="btn btn-warning">Ver</a>
                            <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                class="btn btn-primary">Modificar</a>
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
