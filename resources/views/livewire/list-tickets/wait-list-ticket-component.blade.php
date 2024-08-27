<div class="px-4" wire:poll.5s>
    @if (count($tickets) > 0)
        <div>
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
                    @foreach ($tickets as $item)
                        @php
                            $latestTicketInformation = $item->latestTicketInformation;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $latestTicketInformation ? $latestTicketInformation->title : 'Hubo un Problema al crear el ticket' }}<br>
                                <strong>Tipo:</strong> {{ $item->typeTicket->type }}<br>
                            </td>
                            <td>
                                @if ($latestTicketInformation)
                                    @if ($latestTicketInformation->techniqueTicket)
                                        <strong>Tecnica:</strong>
                                        {{ $latestTicketInformation->techniqueTicket->name }}<br>
                                    @endif
                                @endif
                                @switch($item->latestStatusChangeTicket->status)
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
                                <div class="p-1 alert {{ $color }}"
                                    style="width: 100px;text-align: center;text-transform: uppercase;font-size: smaller;">
                                    {{ $item->latestStatusChangeTicket->status }}</div>
                            </td>
                            <td>{{ $item->seller_name }}</td>
                            <td>{{ $item->priorityTicket->priority }}</td>
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
                                    <button class="boton" wire:click="showTicket({{ $item->id }})">Ver
                                        ticket</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tickets->links() }}
        </div>
        <div wire:ignore.self class="modal fade" id="showTicket" data-bs-backdrop="false" tabindex="-1"
            aria-labelledby="showTicketLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg shadow-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="showTicketLabel">Información del Ticket</h5>
                    </div>
                    <div class="modal-body">
                        @if ($ticket)
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="text-center">{{ $ticket->latestTicketInformation->title }}</h6>
                                    @permission('attend-ticket')
                                        @if ($ticket->seller_id == $ticket->creator_id)
                                            <p class="m-0"><strong>Creado por:
                                                </strong>{{ $ticket->seller_name }}
                                            </p>
                                        @else
                                            <p class="m-0">
                                                <strong>Creado por: </strong> {{ $ticket->creator_name }}
                                            </p>
                                            <p class="m-0">
                                                <strong>Ejecutivo: </strong> {{ $ticket->seller_name }}
                                            </p>
                                        @endif
                                        <p class="m-0">
                                            <strong>Empresa: </strong>{{ $ticket->ticketCreator->profile->company }}
                                        </p>
                                    @endpermission
                                    <hr>
                                    @if ($ticket->latestTicketInformation->customer)
                                        <p class="m-0"><strong>Cliente:
                                            </strong>{{ $ticket->latestTicketInformation->customer }}
                                        </p>
                                    @endif
                                    @if ($ticket->latestTicketInformation->techniqueTicket)
                                        <p class="m-0"><strong>Técnica: </strong>
                                            {{ $ticket->latestTicketInformation->techniqueTicket->name }} <span>
                                        </p>
                                    @endif
                                    @if ($ticket->latestTicketInformation->pantone)
                                        <p class="m-0">
                                            <strong>Color aproximado:</strong>
                                            <small class="m-0 pantone"
                                                style="height: 10px; background-color: {{ $ticket->latestTicketInformation->pantone }}; color: {{ $ticket->latestTicketInformation->pantone }}">.</small>
                                            <small style="display: inline-block">
                                                {{ $ticket->latestTicketInformation->pantone }} </small>
                                        </p>
                                    @endif
                                    @if ($ticket->latestTicketInformation->position)
                                        <p class="m-0"><strong>Posición:
                                            </strong>{{ $ticket->latestTicketInformation->position }}
                                        </p>
                                    @endif
                                    @if ($ticket->latestTicketInformation->link)
                                        <p class="m-0"><strong>Links:
                                            </strong>{{ $ticket->latestTicketInformation->link }}
                                        </p>
                                    @endif
                                    @if ($ticket->latestTicketInformation->companies)
                                        <p class="m-0"><strong>Solicitado para:
                                            </strong>{{ $ticket->latestTicketInformation->companies }}
                                        </p>
                                    @endif
                                    @if ($ticket->latestTicketInformation->samples)
                                        <p class="m-0"><strong>Muestra Fisica:
                                            </strong>{{ $ticket->latestTicketInformation->samples }}
                                        </p>
                                    @endif

                                    <p class="m-0"><strong>Descripción:
                                        </strong>{!! $ticket->latestTicketInformation->description !!}
                                    </p>
                                </div>
                                <div class="col-md-4 overflow-auto" style="max-height: 600px;">
                                    <a href={{ route('descarga.archivosTicket', ['ticket' => $ticket->id]) }}
                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between">
                                        Descargar todo
                                        <span class="fa-fw select-all fas"></span>
                                    </a>
                                    @if ($ticket->latestTicketInformation->logo)
                                        <p class="m-0"><strong>Logo:</strong></p>
                                        @foreach (explode(',', $ticket->latestTicketInformation->logo) as $item)
                                            <div
                                                class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
                                                <div class="name" style="width: 85%">
                                                    {{ Str::substr($item, 11) }}
                                                </div>
                                                <div class="actions d-flex justify-content-around" style="width: 15%">
                                                    <a href="{{ route('tickets.viewFile', ['file' => $item, 'folder' => 'logos']) }}"
                                                        target="_blank">
                                                        <span class="fa-eye fas"></span>
                                                    </a>
                                                    <a href="{{ asset('/storage/logos/' . $item) }}"
                                                        download="{{ Str::substr($item, 11) }}">
                                                        <span class="fa-fw select-all fas"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($ticket->latestTicketInformation->product)
                                        <p class="m-0"><strong>Producto:</strong>
                                        </p>
                                        @foreach (explode(',', $ticket->latestTicketInformation->product) as $item)
                                            <div
                                                class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
                                                <div class="name" style="width: 85%">
                                                    {{ Str::substr($item, 11) }}
                                                </div>
                                                <div class="actions d-flex justify-content-around" style="width: 15%">
                                                    <a href="{{ route('tickets.viewFile', ['file' => $item, 'folder' => 'products']) }}"
                                                        target="_blank">
                                                        <span class="fa-eye fas"></span>
                                                    </a>
                                                    <a href="{{ asset('/storage/products/' . $item) }}"
                                                        download="{{ Str::substr($item, 11) }}">
                                                        <span class="fa-fw select-all fas"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($ticket->latestTicketInformation->items)
                                        <p class="m-0"><strong>Items:</strong></p>
                                        @foreach (explode(',', $ticket->latestTicketInformation->items) as $item)
                                            <div
                                                class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
                                                <div class="name" style="width: 85%">
                                                    {{ Str::substr($item, 11) }}
                                                </div>
                                                <div class="actions d-flex justify-content-around" style="width: 15%">
                                                    <a href="{{ route('tickets.viewFile', ['file' => $item, 'folder' => 'items']) }}"
                                                        target="_blank">
                                                        <span class="fa-eye fas"></span>
                                                    </a>
                                                    <a href="{{ asset('/storage/items/' . $item) }}"
                                                        download="{{ Str::substr($item, 11) }}">
                                                        <span class="fa-fw select-all fas"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    {{--  --}}
                    <div class="modal-footer">
                        @if ($ticket)
                            <!-- Botón que abre el modal -->
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#returnticket">Falta
                                información</button>
                            <div class="modal" id="returnticket" tabindex="-1" wire:ignore.self>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Especifica la falta de información.</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <!-- Formulario para enviar comentario -->
                                            <form action="{{ route('return.ticket') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="message" class="form-label"
                                                        style="font-weight:bolder;">Motivo por el cual se regresa el
                                                        ticket:</label>
                                                    <label for="Info" class="form-label"
                                                        style="text-align: justify; color: #DC143C; font-weight: lighter; font-size: 14px;">Le
                                                        enviaremos al creador del ticket un correo electrónico
                                                        informándole que le hace falta información.</label>
                                                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                                    <input type="hidden" name="ticketid"
                                                        value="{{ $ticket->id }}">
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Manejo si $ticket es nulo -->
                            El ticket no está disponible.
                        @endif
                        <button class="btn btn-primary" onclick="asignarTicket()">Atender Ticket</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Salir</button>
                    </div>
                    {{--  --}}
                </div>
            </div>
        </div>
    @else
        <p class="text-center">
            No hay tickets en espera
        </p>
    @endif

    <script>
        window.addEventListener('showTicket', event => {
            $('#showTicket').modal('show');
        });

        function asignarTicket() {
            let title = '¿Estas seguro de atender este ticket?'
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    let response = @this.assignTicket();
                    response.then((value) => {

                        if (value === 3) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Este ticket ya tiene un diseñador asignado',
                                icon: 'error',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        } else if (value[0] == 1) {
                            $('#showTicket').modal('hide');
                            Swal.fire({
                                title: 'Ticket asignado',
                                icon: 'success'
                            })
                            //
                            window.location.href = "/designer/ticketShow/" + value[1];
                        } else {
                            Swal.fire({
                                title: 'Hubo un problema al asignar el ticket',
                                icon: 'error',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            })
                        }
                    })
                }
            })
        }
    </script>
</div>
