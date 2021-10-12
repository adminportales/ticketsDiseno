@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <div class="row">
            <div class="col-md-3 my-5">
                @include('seller.menu')
            </div>
            <div class="col-md-9">
                <h1>Bienvenido Tomas</h1>
                <h3>Inicio</h3>
                <h2>Tomas Vendedor</h2>
                <br>

                <div class="d-flex">
                    <div class="m-3"> Total de tickets:<b>{{$totalTickets}}</b> </div>

                    <div class="m-3"> Total de tickets abiertos:<b>{{$openTickets}}</b></div>

                    <div class="m-3"> Total de tickets cerrados:<b>{{$closedTickets}}</b></div>

                </div>

                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Categoria de Ticket</th>
                        <th>Estatus</th>
                        <th>Hora de creación</th>

                    </tr>
                    @foreach ($tickets as $ticket )

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$ticket->latestTicketInformation->title}}</td>
                        <td>{{$ticket->typeTicket->type}}</td>
                        <td>{{$ticket->latestTicketInformation->statusTicket->status }}</td>
                        <td>{{ $ticket->latestTicketInformation->created_at }}
                            {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                    </tr>

                    @endforeach

                </table>
            </div>
        </div>
    </div>
@endsection
