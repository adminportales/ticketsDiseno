<div class="card-body">
    <div class="form-group">
        <label for="designer">Buscador</label>
        <input class="form-control" type="text" wire:model='search'
            placeholder="Busqueda por ticket, diseñador y vendedor.Ej. lanyard radius">
    </div>
    <br>
    <table class="table" id="tableTickets">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Info</th>
                <th>Solicitado por:</th>
                <th>Asignado a:</th>
                <th>Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $designersRefactory = [];
            @endphp

            @foreach ($designers as $item)
                @php
                    $designer = [
                        'name' => str_replace(' ', '#', $item->name),
                        'lastname' => str_replace(' ', '#', $item->lastname),
                        'id' => $item->id,
                    ];
                    array_push($designersRefactory, $designer);
                @endphp
            @endforeach
            @foreach ($tickets as $ticket)
                @php
                    $ticketInformation = $ticket->latestTicketInformation;
                @endphp
                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $ticketInformation ? $ticketInformation->title : 'Hubo un Problema al crear el ticket' }}
                    </td>
                    <td>
                        Tipo: {{ $ticket->typeTicket->type }}<br>
                        Prioridad: {{ $ticket->priorityTicket->priority }}<br>
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
                    <td>
                        {{-- <change-designer-assigment designer="{{ $ticket->designer_name }}" :ticket={{ $ticket->id }}
                            :designers=@json($designersRefactory)>
                        </change-designer-assigment> --}}
                        <div class="d-flex">
                            <span></span>

                            <div class="dropdown">
                                <button class="boton btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $ticket->designer_name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        @foreach ($designers as $designer)
                                            <p class="dropdown-item"
                                                wire:click="changeDesigner({{ $designer->id }}, {{ $ticket->id }})">
                                                {{ $designer->name . ' ' . $designer->lastname }}</p>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if ($ticketInformation)
                            {{ $ticketInformation->created_at->diffForHumans() }}
                        @else
                            <p>No se pudo crear el ticket correctamente. Intente mandarlo
                                nuevamente
                            </p>
                        @endif

                    </td>
                    <td>
                        @if ($ticketInformation)
                            <a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}" class="boton-ver">Ver
                                ticket</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tickets->links() }}
    <script>
        let i = 0;
        window.addEventListener('designer-changed', event => {
            i++;
            Toastify({
                text: `Se ha reasignado a ${event.detail.name}`,
                duration: 3000,
                backgroundColor: "#198754",
            }).showToast();
        })
    </script>
</div>
