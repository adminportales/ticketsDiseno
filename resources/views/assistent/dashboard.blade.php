@extends('layouts.app')

@section('title')
    <h3>
        Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
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
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
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
                <div class="col-6 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Tickets creados por mis ejecutivos</h6>
                                    <h6 class="font-extrabold mb-0">{{ $ticketsSellersTotal }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <td>
                                                {{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}
                                                <br>
                                                <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                                            </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    @if ($latestTicketInformation->techniqueTicket)
                                                        <strong>Tecnica:</strong>
                                                        {{ $latestTicketInformation->techniqueTicket->name }}<br>
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

                                                    @case('Finalizado')
                                                        @php $color = 'alert-primary'; @endphp
                                                    @break

                                                    @default
                                                @endswitch
                                                <div class="p-1 m-0 alert {{ $color }}">
                                                    {{ $ticket->latestStatusChangeTicket->status }}</div>
                                            </td>
                                            <td>{{ $ticket->designer_name }}</td>
                                            <td class="text-center"> {{ $ticket->priorityTicket->priority }} </td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    {{ $latestTicketInformation->created_at->diffForHumans() }}
                                                @else
                                                    <p>No se pudo crear el ticket correctamente. Intente mandarlo nuevamente
                                                    </p>
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
                    @if (auth()->user()->team)
                        <div class="card">
                            <div class="card-header">
                                <h4>Ultimos 5 tickets de mis ejecutivos</h4>
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
                                                    @php
                                                        $latestTicketInformation = $ticket->latestTicketInformation;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}
                                                            <br>
                                                            <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                                                        </td>
                                                        <td>
                                                            @if ($latestTicketInformation)
                                                                @if ($latestTicketInformation->techniqueTicket)
                                                                    <strong>Tecnica:</strong>
                                                                    {{ $latestTicketInformation->techniqueTicket->name }}<br>
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
                                                            {{ $ticket->priorityTicket->priority }}
                                                        </td>
                                                        @if ($latestTicketInformation)
                                                            {{ $latestTicketInformation->created_at }} <br>
                                                            {{ $latestTicketInformation->created_at->diffForHumans() }}
                                                        @else
                                                            <p>No se pudo crear el ticket correctamente. Intente mandarlo
                                                                nuevamente
                                                            </p>
                                                        @endif
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
                                    @else
                                        <div class="text-center">
                                            <h6>No hay solicitudes realizadas</h6>
                                        </div>
                                    @endif
                                    <hr> <br>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header my-0 py-3">
                    <h4>Mis Ejecutivos</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @if (auth()->user()->team)
                            @foreach (auth()->user()->team->members as $user)
                                <li class="list-group-item">
                                    {{ $user->name . ' ' . $user->lastname }}
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item">
                                No tienes ejecutivos que atender
                            </li>
                        @endif
                    </ul>
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
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
