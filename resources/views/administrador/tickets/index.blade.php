@extends('layouts.app')

@section('title')
    <h3>Lista de Solicitudes</h3>
@endsection

@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Información general acerca de las solicitudes</h4>
            <a href="{{ route('tickets.create') }}" class="boton">Crear ticket</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="tableTickets">
            <thead>
                <tr>
                    <th>#</th>
                    @role('sales_assistant')
                        <th>Ejecutivo</th>
                    @endrole
                    <th>Titulo</th>
                    <th>Info</th>
                    <th>Asignado a</th>
                    <th>Creado por</th>
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
                        @role('sales_assistant')
                            <td>
                                {{ $ticket->seller_name }}
                            </td>
                        @endrole
                        <td>{{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}
                            <br>
                            <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                        </td>
                        <td>
                            @php $color = ''; @endphp
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
                            <br>
                            <strong>Prioridad:</strong> {{ $ticket->priorityTicket->priority }}
                        </td>
                        <td>{{ $ticket->designer_name }}</td>
                        <td>{{ $ticket->creator_name }}</td>
                        <td>
                            @if ($latestTicketInformation)
                                {{ $latestTicketInformation->created_at }} <br>
                                {{ $latestTicketInformation->created_at->diffForHumans() }}
                            @else
                                <p>No se pudo crear el ticket correctamente. Intente mandarlo nuevamente</p>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($latestTicketInformation)
                                <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}" class="boton-ver">Ver</a>
                                <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                    class="btn btn-danger">Modificar</a>
                            @else
                                <a class="btn btn-danger"
                                    onclick="event.preventDefault();document.getElementById('destroyTicket').submit();">
                                    Eliminar
                                </a>
                                <form id="destroyTicket" action="{{ route('tickets.destroy', ['ticket' => $ticket->id]) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
