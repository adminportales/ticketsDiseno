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
                    <th>Tiempos</th>
                    <th>Fecha de entrega</th>
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
                        
                        <td>
                            @foreach ($ticket->statusChanges as $statusChange)
                                @if ($statusChange === 'Revisar status del ticket')
                                    <p>{{ $statusChange }}</p>
                                @else
                                    <p>{{ $statusChange->created_at }}</p>
                                @endif
                            @endforeach
                        </td>

                        <td class="text-center">
                            @if ($latestTicketInformation)
                                <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}" class="boton-ver" style="display: inline-block; width: 36px; height: 36px;">
                                    <svg width="100%" height="100%" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.984 5.25c-3.653 0-7.401 2.115-10.351 6.344a.75.75 0 0 0-.013.833c2.267 3.548 5.964 6.323 10.364 6.323 4.352 0 8.125-2.783 10.397-6.34a.757.757 0 0 0 0-.819C20.104 8.076 16.303 5.25 11.984 5.25Z"></path>
                                        <path d="M12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"></path>
                                    </svg>
                                </a>

                                <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}" class="btn btn-danger" style="display: inline-block; width: 36px; height: 36px;">
                                    <svg width="100%" height="100%" fill="#fff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.523 5.208a.6.6 0 0 1 0 .847L19.27 7.308l-2.4-2.4 1.252-1.253a.6.6 0 0 1 .848 0l1.552 1.552v.001Zm-2.1 2.947-2.4-2.4-8.176 8.177a.6.6 0 0 0-.145.235l-.966 2.897a.3.3 0 0 0 .38.38l2.896-.967a.6.6 0 0 0 .235-.144l8.176-8.178Z"></path>
                                        <path fill-rule="evenodd" d="M3.12 19.08a1.8 1.8 0 0 0 1.8 1.8h13.2a1.8 1.8 0 0 0 1.8-1.8v-7.2a.6.6 0 1 0-1.2 0v7.2a.6.6 0 0 1-.6.6H4.92a.6.6 0 0 1-.6-.6V5.88a.6.6 0 0 1 .6-.6h7.8a.6.6 0 1 0 0-1.2h-7.8a1.8 1.8 0 0 0-1.8 1.8v13.2Z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
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
