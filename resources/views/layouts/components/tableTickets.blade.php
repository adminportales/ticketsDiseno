<table class="table" id="tableTickets">
    <thead>
        <tr>
            <th>#</th>
            @role('sales_assistant')
                <th>Ejecutivo</th>
            @endrole
            <th>Titulo</th>
            <th>Info</th>
            @permission('create-ticket')
                <th>Asignado a</th>
            @endpermission
            @permission('attend-ticket')
                <th>Creado por</th>
            @endpermission
            @role('sales_manager')
                <th class="text-center">Prioridad</th>
            @endrole
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
                @role('sales_assistant')
                    <td>
                        {{ $ticket->seller_name }}
                    </td>
                @endrole
                <td>{{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}
                    <br>
                    <strong>Tipo:</strong> {{ $ticket->typeTicket->type }}<br>
                </td>
                <td>
                    @switch($ticket->latestStatusChangeTicket->status)
                        @case('Creado')
                            @php $color = 'alert-success'; @endphp
                        @break

                        @case('Falta de información')
                            @php $color = 'alert-warning'; @endphp
                        @break

                        @case('Modificación de ticket')
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

                        @case('Entrega de artes')
                            @php $color = 'alert-secondary'; @endphp
                        @break

                        @case('Solicitud modifación artes')
                            @php $color = 'alert-secondary'; @endphp
                        @break

                        @case('Modificando artes')
                            @php $color = 'alert-secondary'; @endphp
                        @break

                        @case('Finalizado')
                            @php $color = 'alert-primary'; @endphp
                        @break

                        @default
                    @endswitch
                    <strong>Estado:</strong>
                    <div class="p-1 alert {{ $color }}">{{ $ticket->latestStatusChangeTicket->status }}</div><br>
                    <strong>Prioridad:</strong> {{ $ticket->priorityTicket->priority }}
                </td>
                @permission('create-ticket')
                    <td>{{ $ticket->designer_name }}</td>
                @endpermission
                @permission('attend-ticket')
                    <td>{{ $ticket->seller_name }}</td>
                @endpermission
                @role('sales_manager')
                    <td class="text-center">
                        <change-priority priority={{ $ticket->priorityTicket->priority }} :ticket={{ $ticket->id }}
                            :priorities=@json($priorities)>
                        </change-priority>
                    </td>
                @endrole
                <td>
                    @if ($latestTicketInformation)
                        {{ $latestTicketInformation->created_at }} <br>
                        {{ $latestTicketInformation->created_at->diffForHumans() }}
                    @else
                        <p>No se puede ver el ticket correctamente por que hubo un error al crearlo.
                        </p>
                    @endif
                </td>
                <td class="text-center">
                    @if ($latestTicketInformation)
                        <a href="{{ route('tickets.show', ['ticket' => $ticket->id]) }}"
                            class="btn btn-primary btn-sm size-btn mb-2">Ver</a>
                        @if ($ticket->status_id == 6)
                            <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                class="btn btn-secondary  btn-sm size-btn"
                                style="pointer-events: none; cursor: default;">Modificar</a>
                        @else
                            <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}"
                                class="btn btn-danger  btn-sm size-btn">Modificar
                            </a>
                        @endif
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
