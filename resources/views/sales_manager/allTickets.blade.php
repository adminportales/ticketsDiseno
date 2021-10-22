@extends('layouts.app')

@section('title')
    <h3>Lista de Solicitudes</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general acerca de las solicitudes</h4>
    </div>
    <div class="card-body">
        <table class="table" id="tableTickets">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo</th>
                    <th>Categoria de Ticket</th>
                    <th>Estatus</th>
                    <th>Prioridad</th>
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
                        <td class="text-center">
                            @switch($ticket->priorityTicket->priority)
                                @case('Alta')
                                    <span class="badge bg-danger">Alta</span>
                                @break
                                @case('Normal')
                                    <span class="badge bg-warning">Normal</span>
                                @break
                                @case('Baja')
                                    <span class="badge bg-primery">Baja</span>
                                @break
                                @default

                            @endswitch
                            <change-priority :ticket={{ $ticket->id }} :priorities=@json($priorities) ></change-priority>
                        </td>
                        <td>{{ $ticket->latestTicketInformation->created_at }}
                            {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                class="btn btn-warning">Ver</a>
                            <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                class="btn btn-primary">Modificar</a>
                        </td>
                    </tr>
                    {!!$priorities!!}
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\vendors\sweetalert2\sweetalert2.min.css') }}">
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
    <script src="{{ asset('assets\vendors\sweetalert2\sweetalert2.all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
        let priority = @json($priorities);
    </script>
@endsection
