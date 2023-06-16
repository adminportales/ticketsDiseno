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
                    <th>Tiempos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    @php
                        $latestTicketInformation = $ticket->latestTicketInformation;

                        $ticketHistory = $ticket
                            ->historyTicket()
                            ->where('type', 'status')
                            ->orderBy('created_at', 'ASC')
                            ->get();
                        $data = [];
                        foreach ($ticketHistory as $statusHistory) {
                            $status = $statusHistory->ticketStatusChange;
                            array_push($data, $status);
                        }

                        $tiempos = [];
                        $creado = null;
                        $cambio = null;
                        $entregado = null;

                        foreach ($data as $status) {
                            switch ($status->status_id) {
                                case 1:
                                    if ($creado == null) {
                                        $creado = $status->created_at;
                                    }
                                    break;
                                case 3:
                                    if ($creado != null && $cambio == null) {
                                        $entregado = $status->created_at;
                                        // Diff in minutes
                                        $diff = $creado->diffInMinutes($entregado);
                                        array_push($tiempos, ['Creado -> Entregado', $diff]);
                                        $creado = null;
                                    }
                                    if ($cambio != null && $creado == null) {
                                        $entregado = $status->created_at;
                                        $diff = $cambio->diffInMinutes($entregado);
                                        array_push($tiempos, ['Cambio -> Entregado', $diff]);
                                        $cambio = null;
                                    }
                                    break;
                                case 4:
                                    if ($cambio == null) {
                                        $cambio = $status->created_at;
                                    }
                                    break;

                                default:
                                    # code...
                                    break;
                            }
                        }
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @role('sales_assistant')
                            <td>
                                {{ Str::limit($ticket->seller_name, 10, '.') }}
                            </td>
                        @endrole
                        <td>{{ $latestTicketInformation
                            ? Str::limit($latestTicketInformation->title, 10, '...')
                            : 'Hubo un Problema al crear el ticket' }}
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
                            <div class="p-1 alert {{ $color }}" style="width: 100px">
                                {{ $ticket->latestStatusChangeTicket->status }}</div>
                        </td>
                        <td>{{ Str::limit($ticket->designer_name, 10, '...') }}</td>
                        <td>{{ Str::limit($ticket->creator_name, 10, '...') }}</td>
                        <td>
                            @if ($latestTicketInformation)
                                {{ $latestTicketInformation->created_at }} <br>
                                {{ $latestTicketInformation->created_at->diffForHumans() }}
                            @else
                                <p>No se pudo crear el ticket correctamente. Intente mandarlo nuevamente</p>
                            @endif
                        </td>
                        <td>
                            @foreach ($tiempos as $tiempo)
                                <p style="font-size: 10px" class="m-0">{{ $tiempo[0] . ': ' . $tiempo[1] }}</p>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if ($latestTicketInformation)
                                <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}" class="boton-ver">V</a>
                                <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                    class="btn btn-danger">M</a>
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
        {{ $tickets->links() }}
    </div>
@endsection

@section('styles')
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
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
@endsection
