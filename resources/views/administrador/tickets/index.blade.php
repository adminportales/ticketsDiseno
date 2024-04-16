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
                    <th>Fecha de creación</th>
                    <th>Fecha de entrega</th>
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
                        $Falta_de_información = null;
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

                                case 5:
                                    if ($Falta_de_información == null) {
                                        $$Falta_de_información = $status->created_at;
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
                            <div class="p-1 alert {{ $color }}"
                                style="width: 100px;text-align: center;text-transform: uppercase;font-size: smaller;">
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
                            @foreach ($ticket->statusChanges as $statusChange)
                                @if ($statusChange === 'Revisar status del ticket')
                                    <p>{{ $statusChange }}</p>
                                @else
                                    <p>{{ $statusChange->created_at }}</p>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($tiempos as $tiempo)
                                <p style="font-size: 10px" class="m-0">{{ $tiempo[0] . ': ' . $tiempo[1] }}</p>
                            @endforeach
                        </td>

                        <td class="text-center">
                            @if ($latestTicketInformation)
                                <div style="display: flex;">
                                    <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                                        style="display: inline-block; width: 36px; height: 36px; padding: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                        style="display: inline-block; width: 36px; height: 36px; padding: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="red" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                </div>
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
