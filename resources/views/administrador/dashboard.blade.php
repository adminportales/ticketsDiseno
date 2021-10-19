@extends('layouts.app')

@section('title')
    <h3>Bienvenido Administrador</h3>
@endsection

@section('content')

    <div class="card-header">
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
                            <td>{{ $ticket->latestTicketInformation->statusTicket->status }}</td>
                            <td>{{ $ticket->latestTicketInformation->created_at }}
                                {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                            <td><a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}"
                                    class="btn btn-warning">Ver
                                    ticket</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endsection

        @section('styles')
            <link rel="stylesheet"
                href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
            {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}"> --}}
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
            {{-- <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script> --}}
            <script>
                // Jquery Datatable
                let jquery_datatable = $("#tableTickets").DataTable()
            </script>
        @endsection
