@extends('layouts.app')

@section('title')
    <h3>Mis tickets</h3>
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
                    <th>Info</th>
                    <th>Solicitado por</th>
                    <th>Prioridad</th>
                    <th>Hora de creación</th>
                    <th>Acciones</th>
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
                        <td><a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}" class="boton">Ver
                                ticket</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
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
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script> --}}
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
