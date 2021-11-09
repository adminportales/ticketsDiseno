<table class="table" id="tableTickets">
    <thead>
        <tr>
            <th>#</th>
            @role('sales_assistant')
                <th>Ejecutivo</th>
            @endrole
            <th>Titulo</th>
            <th>Info</th>
            @role('sales_manager|seller')
                <th>Asignado a</th>
            @endrole
            @role('design_manager|designer')
                <th>Creado por</th>
            @endrole
            @role('sales_manager')
                <th class="text-center">Prioridad</th>
            @endrole
            <th>Hora de creación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tickets as $ticket)
            <tr>
                <td>{{ $loop->iteration }}</td>
                @role('sales_assistant')
                    <td>
                        {{ $ticket->seller_name }}
                    </td>
                @endrole
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
                @role('sales_manager|seller')
                    <td>{{ $ticket->designer_name }}</td>
                @endrole
                @role('design_manager|designer')
                    <td>{{ $ticket->seller_name }}</td>
                @endrole
                @role('sales_manager')
                    <td class="text-center">
                        <change-priority priority={{ $ticket->priorityTicket->priority }} :ticket={{ $ticket->id }}
                            :priorities=@json($priorities)>
                        </change-priority>
                    </td>
                @endrole
                <td>{{ $ticket->latestTicketInformation->created_at }} <br>
                    {{ $ticket->latestTicketInformation->created_at->diffForHumans() }}</td>
                <td class="text-center">
                    <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}" class="boton-ver ">Ver</a>
                    <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                        class="btn btn-danger">Modificar</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
