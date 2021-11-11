@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
@endsection

@section('dashboard')
    <section class="row">
        <div class="col-12 col-lg-8">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Mis ultimos 5 tickets pendientes</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Titulo</th>
                                        <th>Info</th>
                                        <th>Solicitado por:</th>
                                        <th>Prioridad</th>
                                        <th>Hora de creación</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
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
                                                <strong>Estado:</strong> {{ $ticket->latestStatusChangeTicket->status }}
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
                                            <td>{{ $ticket->latestTicketInformation->created_at }}
                                                {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header my-0 py-3">
                    <h4>Notificaciones Recientes</h4>
                </div>
                <div class="card-body">
                    <div class="">
                        @foreach (auth()->user()->notifications as $notification)

                            <div class="border rounded p-1 my-1">
                                <h6 class="mb-1"><strong>Nombre del ticket: </strong>{{ $notification->data['ticket'] }}</h6>
                                <p class="m-0"><strong>Emisor: </strong>{{ $notification->data['emisor'] }} </p>
                                @switch($notification->type)

                                    @case('App\Notifications\TicketCreateNotification')

                                        <p class="m-0"><strong>Mensaje: </strong>Se creo el ticket </p>


                                    @break
                                    @case(2)

                                    @break
                                    @default

                                @endswitch
                            </div>
                            <div class="d-flex justify-content-around">
                                <a href="">Marcar como leido</a>
                                <a href="">Ver</a>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tickets asignados a mi equipo</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th>Info</th>
                                        <th>Solicitado por:</th>
                                        <th>Asignado a:</th>
                                        <th>Hora de creación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $designersRefactory = [];
                                    @endphp

                                    @foreach ($designers as $item)
                                        @php
                                            $designer = [
                                                'name' => str_replace(' ', '#', $item->name),
                                                'lastname' => str_replace(' ', '#', $item->lastname),
                                                'id' => $item->id,
                                            ];
                                            array_push($designersRefactory, $designer);
                                        @endphp
                                    @endforeach
                                    @foreach ($tickets as $ticket)
                                        @php
                                            $ticketInformation = $ticket->latestTicketInformation;
                                        @endphp
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ticketInformation->title }}</td>
                                            <td>
                                                Tipo: {{ $ticket->typeTicket->type }}<br>
                                                Prioridad: {{ $ticket->priorityTicket->priority }}<br>
                                                Estado: {{ $ticket->latestStatusChangeTicket->status }}
                                            </td>
                                            <td>
                                                @if ($ticket->seller_id == $ticket->creator_id)
                                                    {{ $ticket->seller_name }}
                                                @else
                                                    {{ $ticket->creator_name }} <br>
                                                    <strong>Ejecutivo:</strong>{{ $ticket->seller_name }}
                                                @endif
                                            </td>
                                            <td>
                                                <change-designer-assigment designer="{{ $ticket->designer_name }}"
                                                    :ticket={{ $ticket->id }} :designers=@json($designersRefactory)>
                                                </change-designer-assigment>
                                            </td>
                                            <td>
                                                {{ $ticketInformation->created_at->diffForHumans() }}
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
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Mi equipo</h4>
                </div>
                <div class="card-content pb-4">
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="assets/images/faces/4.jpg">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Aide </h5>
                            <h6 class="text-muted mb-0">@aide</h6>
                        </div>
                    </div>
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="assets/images/faces/5.jpg">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Fernanda</h5>
                            <h6 class="text-muted mb-0">@fer</h6>
                        </div>
                    </div>
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="assets/images/faces/1.jpg">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Ived</h5>
                            <h6 class="text-muted mb-0">@ived</h6>
                        </div>
                    </div>
                    <div class="px-4">

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
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
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
