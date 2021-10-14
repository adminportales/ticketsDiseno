@extends('layouts.app')
@section('title')
    <h3>Lista de Solicitudes</h3>
@endsection
@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general acerca de las solicitudes</h4>
    </div>
    <div class="card-body">
        <h1>Bienvenido Tomas</h1>
        <h3>Inicio</h3>
        <h2>Tomas Vendedor</h2>
        <br>

        <div class="d-flex">
            <div class="m-3"> Total de tickets:<b>{{ $totalTickets }}</b> </div>

            <div class="m-3"> Total de tickets abiertos:<b>{{ $openTickets }}</b></div>

            <div class="m-3"> Total de tickets cerrados:<b>{{ $closedTickets }}</b></div>

        </div>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Categoria de Ticket</th>
                <th>Estatus</th>
                <th>Hora de creación</th>

            </tr>
            @foreach ($tickets as $ticket)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->latestTicketInformation->title }}</td>
                    <td>{{ $ticket->typeTicket->type }}</td>
                    <td>{{ $ticket->latestTicketInformation->statusTicket->status }}</td>
                    <td>{{ $ticket->latestTicketInformation->created_at }}
                        {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                    <td><a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}" class="btn btn-warning">Ver
                            ticket</a></td>
                    <td><a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}" class="btn btn-primary">Modificar
                            tickets</a></td>
                </tr>

            @endforeach

        </table>
    </div>
@endsection
