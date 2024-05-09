@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
@endsection

@section('dashboard')
    <section class="row">
        <div class="col-12 col-lg-12">
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
                @if (!empty($ticketAssistant))
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
                                        <h6 class="text-muted font-semibold">Tickets creados por mi asistente</h6>
                                        <h6 class="font-extrabold mb-0">{{ count($ticketAssistant) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
                                        <th>Asignado a</th>
                                        <th class="text-center">Prioridad</th>
                                        <th>Fecha de creación</th>
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
                                            <td>{{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}<br>
                                                <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                                            </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    @if ($ticket->latestTicketInformation->techniqueTicket)
                                                        <strong>Tecnica:</strong>
                                                        {{ $ticket->latestTicketInformation->techniqueTicket->name }}<br>
                                                    @endif
                                                @endif
                                                @switch($ticket->latestStatusChangeTicket->status)
                                                    @case('Creado')
                                                        @php $color = 'alert-success'; @endphp
                                                    @break

                                                    @case('Falta de información')
                                                        @php $color = 'alert-warning'; @endphp
                                                    @break

                                                    @case('En revision')
                                                        @php $color = 'alert-warning'; @endphp
                                                    @break

                                                    @case('Diseño en proceso')
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

                                                    @case('Solicitar artes')
                                                        @php $color = 'alert-secondary'; @endphp
                                                    @break

                                                    @case('Entrega de artes')
                                                        @php $color = 'alert-secondary'; @endphp
                                                    @break

                                                    @case('Finalizado')
                                                        @php $color = 'alert-primary'; @endphp
                                                    @break

                                                    @default
                                                @endswitch
                                                <strong>Estado:</strong>
                                                <div class="p-1 alert {{ $color }}">
                                                    {{ $ticket->latestStatusChangeTicket->status }}</div>
                                            </td>
                                            <td>{{ $ticket->designer_name }}</td>
                                            <td class="text-center"> {{ $ticket->priorityTicket->priority }} </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    {{ $latestTicketInformation->created_at->diffForHumans() }}
                                                @else
                                                    <p>No se puede ver el ticket correctamente por que hubo un error al
                                                        crearlo.
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                                        class="boton">Ver
                                                        ticket</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (!empty($assistant))
                        <div class="card">
                            <div class="card-header">
                                <h4>Ultimos 5 Tickets Pendientes Creados por
                                    {{ $assistant->name . ' ' . $assistant->lastname }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Titulo</th>
                                            <th>Info</th>
                                            <th>Asignado a</th>
                                            <th>Prioridad</th>
                                            <th>Fecha de creación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticketAssistant as $ticket)
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
                                                    @switch($ticket->latestStatusChangeTicket->status)
                                                        @case('Creado')
                                                            @php $color = 'alert-success'; @endphp
                                                        @break

                                                        @case('Falta de información')
                                                            @php $color = 'alert-warning'; @endphp
                                                        @break

                                                        @case('En revision')
                                                            @php $color = 'alert-warning'; @endphp
                                                        @break

                                                        @case('Diseño en proceso')
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

                                                        @case('Solicitar artes')
                                                            @php $color = 'alert-secondary'; @endphp
                                                        @break

                                                        @case('Entrega de artes')
                                                            @php $color = 'alert-secondary'; @endphp
                                                        @break

                                                        @case('Finalizado')
                                                            @php $color = 'alert-primary'; @endphp
                                                        @break

                                                        @default
                                                    @endswitch
                                                    <strong>Estado:</strong>
                                                    <div class="p-1 alert {{ $color }}">
                                                        {{ $ticket->latestStatusChangeTicket->status }}</div>
                                                </td>
                                                <td>{{ $ticket->designer_name }}</td>
                                                <td>{{ $ticket->priorityTicket->priority }}</td>
                                                <td>{{ $ticket->latestTicketInformation->created_at->diffForHumans() }}
                                                </td>
                                                <td><a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                                        class="boton">Ver ticket</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    {{-- @if (!empty($ticketsSellers))
                        <div class="card">
                            <div class="card-header">
                                <h4>Ultimos 5 tickets de mi equipo</h4>
                            </div>
                            <div class="card-body">
                                @foreach ($ticketsSellers as $ticketsSeller)
                                    <h5>{{ $ticketsSeller['seller']->name . ' ' . $ticketsSeller['seller']->lastname }}
                                    </h5>
                                    @if (count($ticketsSeller['tickets']))
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Titulo</th>
                                                    <th>Info</th>
                                                    <th>Asignado a</th>
                                                    <th class="text-center">Prioridad</th>
                                                    <th>Fecha de creación</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ticketsSeller['tickets'] as $ticket)
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
                                                            <strong>Estado:</strong>
                                                            {{ $ticket->latestStatusChangeTicket->status }}
                                                        </td>
                                                        <td>{{ $ticket->designer_name }}</td>
                                                        <td class="text-center">
                                                            {{ $ticket->priorityTicket->priority }}
                                                        </td>
                                                        <td> {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                                                class="boton">Ver ticket</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="text-center">
                                            <h6>No hay solicitudes realizadas</h6>
                                        </div>
                                    @endif
                                    <hr> <br>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </section>
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
    <script defer>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
