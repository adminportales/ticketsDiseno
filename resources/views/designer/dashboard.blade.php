@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name }}</h3>
@endsection

@section('dashboard')
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>Tickets en Espera de tu aprobacion</h4>
                    @if (count($ticketsToTransfer) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titulo</th>
                                    <th>Info</th>
                                    <th>Solicitado por</th>
                                    <th>Prioridad</th>
                                    <th>Hora de creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ticketsToTransfer as $ticketToTransfer)
                                    @php
                                        $latestTicketInformation = $ticketToTransfer->latestTicketInformation;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}
                                            <br>
                                            <strong>Tipo:</strong> {{ $ticketToTransfer->typeTicket->type }}<br>
                                        </td>
                                        <td>
                                            @php $color = ''; @endphp
                                            @switch($ticketToTransfer->latestStatusChangeTicket->status)
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
                                            <div class="p-1 alert {{ $color }}">
                                                {{ $ticketToTransfer->latestStatusChangeTicket->status }}</div>
                                        </td>
                                        <td>
                                            @if ($ticketToTransfer->seller_id == $ticketToTransfer->creator_id)
                                                {{ $ticketToTransfer->seller_name }}
                                            @else
                                                {{ $ticketToTransfer->creator_name }} <br>
                                                <strong>Ejecutivo:</strong>{{ $ticketToTransfer->seller_name }}
                                            @endif
                                        </td>
                                        <td>{{ $ticketToTransfer->priorityTicket->priority }}</td>
                                        <td>
                                            @if ($latestTicketInformation)
                                                {{ $latestTicketInformation->created_at->diffForHumans() }}
                                            @else
                                                <p>No se pudo crear el ticket correctamente. Intente mandarlo
                                                    nuevamente
                                                </p>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('designer.show', $ticketToTransfer) }}"
                                                class="btn btn-primary btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">No tienes tickets en espera</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Mis Ultimos 5 Tickets Pendientes</h4>
                            <div class="d-flex">
                                <p class="m-0">Mi Disponibilidad:</p>
                                <change-status-designer :availability={{ auth()->user()->profile->availability }}
                                    :user={{ auth()->user()->id }}>
                                </change-status-designer>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Info</th>
                                        <th>Solicitado por</th>
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
                                            <td>
                                                {{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}
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
                                                <div class="p-1 alert {{ $color }}">
                                                    {{ $ticket->latestStatusChangeTicket->status }}</div>
                                            </td>
                                            <td>
                                                @if ($ticket->seller_id == $ticket->creator_id)
                                                    {{ $ticket->seller_name }}
                                                @else
                                                    {{ $ticket->creator_name }} <br>
                                                    <strong>Ejecutivo:</strong>{{ $ticket->seller_name }}
                                                @endif
                                            </td>
                                            <td>{{ $ticket->priorityTicket->priority }}</td>
                                            <td>
                                                @if ($latestTicketInformation)
                                                    {{ $latestTicketInformation->created_at->diffForHumans() }}
                                                @else
                                                    <p>No se pudo crear el ticket correctamente. Intente mandarlo
                                                        nuevamente
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('designer.show', $ticket) }}"
                                                    class="btn btn-primary btn-sm">Ver</a>
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
