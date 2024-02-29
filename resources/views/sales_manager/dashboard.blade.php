@extends('layouts.app')

@section('title')
    <h3>
        Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
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
                                    <h6 class="text-muted font-semibold">Total de tickets</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalTickets }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <h6 class="text-muted font-semibold">Ejecutivos</h6>
                                    <h6 class="font-extrabold mb-0">{{ $userSeller }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Asistentes</h6>
                                    <h6 class="font-extrabold mb-0">{{ $userAssitent }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Mis ultimos tickets creados</h4>
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
                                        <th>Hora de creación</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        @php
                                            $latestTicketInformation = $ticket->latestTicketInformation;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}
                                                <br>
                                                <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                                            </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    @if ($ticket->latestTicketInformation->techniqueTicket)
                                                        <strong>Tecnica:</strong>
                                                        {{ $ticket->latestTicketInformation->techniqueTicket->name }}<br>
                                                    @endif
                                                @endif
                                                @php $color = ''; @endphp
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
                                                <div class="p-1 alert {{ $color }}">
                                                    {{ $ticket->latestStatusChangeTicket->status }}</div>
                                            </td>
                                            <td>{{ $ticket->designer_name }}</td>
                                            <td class="text-center">
                                                <change-priority priority={{ $ticket->priorityTicket->priority }}
                                                    :ticket={{ $ticket->id }} :priorities=@json($priorities)>
                                                </change-priority>
                                            </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    {{ $latestTicketInformation->created_at->diffForHumans() }}
                                                @else
                                                    <p>No se pudo crear el ticket correctamente</p>
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
                                            <th>Hora de creación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticketAssistant as $ticket)
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
                                                    <div class="p-1 alert {{ $color }}">
                                                        {{ $ticket->latestStatusChangeTicket->status }}</div>
                                                </td>
                                                <td>{{ $ticket->designer_name }}</td>
                                                <td>{{ $ticket->priorityTicket->priority }}</td>
                                                <td>
                                                    @if ($latestTicketInformation)
                                                        {{ $latestTicketInformation->created_at->diffForHumans() }}
                                                    @else
                                                        <p>No se pudo crear el ticket correctamente</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($latestTicketInformation)
                                                        <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                                            class="boton">Ver ticket</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>Ultimos tickets creados por mi equipo</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Info</th>
                                        <th>Creado por</th>
                                        <th>Asignado a</th>
                                        <th class="text-center">Prioridad</th>
                                        <th>Hora de creación</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allTickets as $ticket)
                                        @php
                                            $latestTicketInformation = $ticket->latestTicketInformation;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}<br>
                                                <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                                            </td>
                                            <td>
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
                                                <div class="p-1 alert {{ $color }}">
                                                    {{ $ticket->latestStatusChangeTicket->status }}</div>
                                            </td>
                                            <td>
                                                @if ($ticket->seller_id == $ticket->creator_id)
                                                    {{ $ticket->creator_id == auth()->user()->id ? 'Yo' : $ticket->seller_name }}
                                                @else
                                                    {{ $ticket->creator_name }} <br>
                                                    <strong>Ejecutivo:</strong>{{ $ticket->seller_name }}
                                                @endif
                                            </td>
                                            <td>{{ $ticket->designer_name }}</td>
                                            <td class="text-center">
                                                <change-priority priority={{ $ticket->priorityTicket->priority }}
                                                    :ticket={{ $ticket->id }} :priorities=@json($priorities)>
                                                </change-priority>
                                            </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    {{ $latestTicketInformation->created_at->diffForHumans() }}
                                                @else
                                                    <p>No se pudo crear el ticket correctamente</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
