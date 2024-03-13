<div class="card-body">
    <div class="flex">

        <div class="form-group">
            <label for="designer">Buscador</label>
            <input class="form-control" type="text" wire:model='search'
                placeholder="Busqueda por ticket y vendedor. Ej. lanyard radius">
        </div>
        {{--         <div class="form-group">
            <label for="designer">Estado</label>
            <select class="form-control" wire:model='status'>
                <option value="">Todos</option>
                @foreach ($statusTickets as $statusTicket)
                    <option value="{{ $statusTicket->id }}">{{ $statusTicket->status }}</option>
                @endforeach
            </select>
        </div> --}}
    </div>
    <br>
    <table class="table" id="tableTickets">
        <thead>
            <tr>
                <th>#</th>
                <th>Titulo</th>
                <th>Info</th>
                <th>Elaboro</th>
                <th>Prioridad</th>
                <th>Fecha de creación</th>
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
                    <td>{{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}<br>
                        <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                    </td>
                    <td>
                        @if ($latestTicketInformation)
                            @if ($latestTicketInformation->techniqueTicket)
                                <strong>Tecnica:</strong>
                                {{ $latestTicketInformation->techniqueTicket->name }}<br>
                            @endif
                        @endif
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

                            @case('Finalizado')
                                @php $color = 'alert-primary'; @endphp
                            @break

                            @default
                        @endswitch
                        <strong>Estado:</strong>
                        <div class="p-1 alert {{ $color }}">{{ $ticket->latestStatusChangeTicket->status }}</div>
                    </td>
                    <td>{{ $ticket->seller_name }}</td>
                    <td>{{ $ticket->priorityTicket->priority }}</td>
                    <td>
                        @if ($latestTicketInformation)
                            {{ $latestTicketInformation->created_at }}
                            {{ $latestTicketInformation->created_at->diffForHumans() }}
                        @else
                            <p>Hubo un problema al crear el ticket</p>
                        @endif
                    </td>
                    <td>
                        @if ($latestTicketInformation)
                            <a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}" class="boton">Ver
                                ticket</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tickets->links() }}
</div>
