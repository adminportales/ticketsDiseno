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
                    @php
                        $latestTicketInformation = $ticket->latestTicketInformation;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $latestTicketInformation->title }} <br>
                            <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                        </td>
                        <td>
                            @if ($latestTicketInformation->techniqueTicket)
                                <strong>Tecnica:</strong>
                                {{ $latestTicketInformation->techniqueTicket->name }}<br>
                            @endif
                            @switch($ticket->latestStatusChangeTicket->status)
                                @case('Creado')
                                    @php $color = 'alert-success'; @endphp
                                @break

                                @case('En revision')
                                    @php $color = 'alert-warning'; @endphp
                                @break

                                @case('Entregado')
                                    @php $color = 'alert-info'; @endphp
                                @break

                                @case('Solicitud de ajustes')
                                    @php $color = 'alert-danger'; @endphp
                                @break

                                @case('Realizando ajustes')
                                    @php $color = 'alert-secondary'; @endphp
                                @break

                                @case('Finalizado')
                                    @php $color = 'alert-primary'; @endphp
                                @break

                                @default
                            @endswitch
                            <strong>Estado:</strong>
                            <div class="p-1 alert {{ $color }}">{{ $ticket->latestStatusChangeTicket->status }}</div>
                        </td>
                        <td>{{ $ticket->seller_name }}</td>
                        <td>{{ $ticket->priorityTicket->priority }}</td>
                        <td>
                            @if ($latestTicketInformation)
                                {{ $latestTicketInformation->created_at }}
                                {{ $latestTicketInformation->created_at->diffForHumans() }}
                            @else
                                <p>Hubo un problema al crear el ticket</p>
                            @endif
                        </td>
                        <td>
                            @if ($latestTicketInformation)
                                <a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}" class="boton">Ver
                                    ticket</a>
                            @endif
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
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
