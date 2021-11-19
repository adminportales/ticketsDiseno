@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
@endsection

@section('dashboard')
    <section class="row">
        <div class="col-12 col-lg-8">
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
                            @foreach ($ticketsPropios as $ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->latestTicketInformation->title }} <br>
                                        <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                                    </td>
                                    <td>
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
                                    <td>{{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Ultimos 5 tickets pendientes de mi equipo</h4>
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
                                    <td>{{ $ticketInformation->title }} <br>
                                        <strong>Tipo: </strong> {{ $ticket->typeTicket->type }}<br>
                                    </td>
                                    <td>

                                        <strong>Prioridad:</strong> {{ $ticket->priorityTicket->priority }}<br>
                                        <strong>Estado: </strong> {{ $ticket->latestStatusChangeTicket->status }}
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
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Mi equipo</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($designers as $user)
                            <li class="list-group-item d-flex justify-content-between">
                                <p class="m-0">{{ $user->name . ' ' . $user->lastname }}</p>
                                <div>
                                    <change-status-designer :availability={{ $user->profile->availability }}
                                        :user={{ $user->id }}>
                                    </change-status-designer>
                                </div>
                            </li>
                        @endforeach
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
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
