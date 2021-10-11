@extends('layouts.app')

@section('content')

    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Bienvenido {{ auth()->user()->name }}</h1>
        <h3>Inicio</h3>
        <ul>
            <li><a href="{{ route('inicio_diseno') }}">Inicio</a></li>
            <li><a href="{{ route('consultar_ticket_diseño') }}">Consultar Ticket</a></li>

        </ul>
        <br>
        <div class="d-flex justify-content-between p-3">
            <div> Total de tickets:<b>{{ $totalTickets }}</b></div>
            <div> Total de tickets abiertos:<b>{{ $openTickets }}</b></div>
            <div> Total de tickets cerrados:<b>{{ $closedTickets }}</b></div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Categoria de Ticket</th>
                    <th>Prioridad</th>
                    <th>Estatus</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->latestTicketInformation->title }}</td>
                        <td>{{ $ticket->typeTicket->type }}</td>
                        <td>{{ $ticket->priorityTicket->priority }}</td>
                        <td>{{ $ticket->latestTicketInformation->statusTicket->status }}</td>
                        <td>{{ $ticket->latestTicketInformation->created_at }}
                            {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
