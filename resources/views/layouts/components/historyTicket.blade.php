<section class="border-0 row">
    <div class="col-md-8">
        @role('designer|design_manager')
            <p class="m-0"><strong>Creado por:
                </strong>{{ $ticket->seller_name }}
            </p>
        @endrole
        @role('seller|sales_manager')
            <p class="m-0"><strong>Asignado a:
                </strong>{{ $ticket->designer_name }}
            </p>
        @endrole
        <hr>
        @if ($ticket->latestTicketInformation->customer)
            <p class="m-0"><strong>Cliente:
                </strong>{{ $ticket->latestTicketInformation->customer }}
            </p>
        @endif
        @if ($ticket->latestTicketInformation->techniqueTicket)
            <p class="m-0"><strong>Tecnica:
                </strong>{{ $ticket->latestTicketInformation->techniqueTicket->name }} <span>
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
        <p class="m-0"><strong>Descripción:
            </strong>{{ $ticket->latestTicketInformation->description }}
        </p>
    </div>
    <div class="col-md-4 overflow-auto" style="max-height: 200px;">
        <a href={{ route('descarga.archivosTicket', ['ticket' => $ticket->id]) }}
            class="btn btn-sm btn-light w-100 d-flex justify-content-between">
            Descargar todo
            <span class="fa-fw select-all fas"></span>
        </a>
        @if ($ticket->latestTicketInformation->logo)
            <p class="m-0"><strong>Logo:</strong></p>
            <a href="{{ asset('/storage/logos/' . $ticket->latestTicketInformation->logo) }}"
                class="btn btn-sm btn-light w-100 d-flex justify-content-between" download>
                {{ Str::limit($ticket->latestTicketInformation->logo, 16) }}
                <span class="fa-fw select-all fas"></span>
            </a>
        @endif
        @if ($ticket->latestTicketInformation->product)
            <p class="m-0"><strong>Producto:</strong>
            </p>
            <a href="{{ asset('/storage/products/' . $ticket->latestTicketInformation->product) }}"
                class="btn btn-sm btn-light w-100 d-flex justify-content-between" download>
                {{ Str::limit($ticket->latestTicketInformation->product, 16) }}
                <span class="fa-fw select-all fas"></span>
            </a>
        @endif
        @if ($ticket->latestTicketInformation->items)
            <p class="m-0"><strong>Items:</strong></p>
            @foreach (explode(',', $ticket->latestTicketInformation->items) as $item)
                <a href="{{ asset('/storage/items/' . $item) }}"
                    class="btn btn-sm btn-light w-100 d-flex justify-content-between" download>
                    {{ Str::limit($item, 16) }}
                    <span class="fa-fw select-all fas"></span>
                </a>
            @endforeach
        @endif
    </div>
</section>
<hr>
<section class="border-0">
    <h5>Historial</h5>
    <form action="{{ route('message.store') }}" method="post">
        @csrf
        @method('POST')
        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
        <div class="d-flex">
            <div class="form-group flex-grow-1">
                <input type="text" class="form-control" placeholder="Agrega una nota adicional" name="message">
            </div>
            <input type="submit" class="boton-enviar" value="Enviar">
        </div>
    </form>
    <div class="d-flex flex-column-reverse">
        @php
            $latestInformation = null;
        @endphp
        @foreach ($ticketHistories as $ticketHistory)
            @if ($ticketHistory->type == 'info')
                @php $information = $ticketHistory->ticketInformation; @endphp
                <div class="border border-primary rounded px-3 py-2 my-1">
                    <div class="row">
                        @if ($latestInformation)
                            <div class="col-md-12">
                                @if ($information->title != $latestInformation->title)
                                    <p class="m-0"><strong>Titulo:
                                        </strong>{{ $latestInformation->title }}
                                        <span class="fa-fw select-all fas"></span>
                                        {{ $information->title }}
                                    </p>
                                @endif
                                @if ($information->customer)
                                    @if ($information->customer != $latestInformation->customer)
                                        <p class="m-0"><strong>Cliente:
                                            </strong>{{ $latestInformation->customer }} <span
                                                class="fa-fw select-all fas"></span>
                                            {{ $information->customer }}
                                        </p>
                                    @endif
                                @endif
                                @if ($information->techniqueTicket)
                                    @if ($information->techniqueTicket->name != $latestInformation->techniqueTicket->name)
                                        <p class="m-0"><strong>Tecnica:
                                            </strong>{{ $latestInformation->techniqueTicket->name }}
                                            <span class="fa-fw select-all fas"></span>
                                            {{ $information->techniqueTicket->name }}
                                        </p>
                                    @endif
                                @endif
                                @if ($information->pantone != $latestInformation->pantone)
                                    <p class="m-0">
                                        <strong>Color aproximado:</strong>
                                        <small class="m-0 pantone"
                                            style="height: 10px; background-color: {{ $latestInformation->pantone }}; color: {{ $latestInformation->pantone }}">.</small>
                                        <small style="display: inline-block">
                                            {{ $latestInformation->pantone }} </small> <span
                                            class="fa-fw select-all fas"></span>
                                        <small class="m-0 pantone"
                                            style="height: 10px; background-color: {{ $information->pantone }}; color: {{ $information->pantone }}">.</small>
                                        <small style="display: inline-block"> {{ $information->pantone }}
                                        </small>
                                    </p>
                                @endif
                                @if ($latestInformation && $information->description != $latestInformation->description)
                                    <p class="m-0"><strong>Descripción:
                                        </strong>{{ $latestInformation->description }} <span
                                            class="fa-fw select-all fas"></span>
                                        {{ $information->description }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @if ($information->logo != $latestInformation->logo)
                                        <div class="col-md-12 col-sm-12">
                                            <p class="m-0"><strong>Logo:
                                                </strong>
                                            </p>
                                            <img src="{{ asset('/storage/logos/' . $latestInformation->logo) }}"
                                                alt="" class="img-thumbnail rounded img-history">
                                            <span class="fa-fw select-all fas"></span>
                                            <img src="{{ asset('/storage/logos/' . $information->logo) }}" alt=""
                                                class="img-thumbnail rounded img-history">
                                        </div>
                                    @endif
                                    @if ($information->product != $latestInformation->product)
                                        <div class="col-md-12 col-sm-12">
                                            <p class="m-0"><strong>Producto:
                                                </strong>
                                            </p>
                                            <img src="{{ asset('/storage/products/' . $latestInformation->product) }}"
                                                alt="" class="img-thumbnail rounded img-history">
                                            <span class="fa-fw select-all fas"></span>
                                            <img src="{{ asset('/storage/products/' . $information->product) }}"
                                                alt="" class="img-thumbnail rounded img-history">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @php
                                $diferencias = array_diff(explode(',', $information->items), explode(',', $latestInformation->items));
                            @endphp
                            @if (!empty($diferencias))
                                <p class="m-0"><strong>Items: </strong></p>
                                <div class="col-md-5">
                                    <div class="items">
                                        @foreach (explode(',', $latestInformation->items) as $item)
                                            <div class="img-items ">
                                                <img src="{{ asset('/storage/items/' . $item) }}" alt=""
                                                    class="img-thumbnail rounded">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <span class="fa-fw select-all fas"></span>
                                </div>
                                <div class="col-md-5">
                                    <div class="items">
                                        @foreach (explode(',', $information->items) as $item)
                                            <div class="img-items ">
                                                <img src="{{ asset('/storage/items/' . $item) }}" alt=""
                                                    class="img-thumbnail rounded">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @elseif (!$latestInformation && $loop->index == 0)
                            <p class="m-0">
                                <strong>Creacion del ticket</strong>
                            </p>
                        @endif
                        <p class="m-0" style="font-size: .8rem">
                            {{ $information->modifier_id == auth()->user()->id ? 'Yo' : $information->modifier_name }}
                            {{ $information->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @php $latestInformation = $information; @endphp
            @elseif ($ticketHistory->type == 'message')
                @php $message = $ticketHistory->ticketMessage; @endphp
                <div
                    class="border rounded px-3 py-2 my-1
                    {{ $message->transmitter_id == auth()->user()->id ? 'border-success' : 'border-warning' }}">
                    <p class="m-0 ">{{ $message->message }}</p>
                    <p class="m-0 " style="font-size: .8rem">
                        {{ $message->transmitter_id == auth()->user()->id ? 'Yo' : $message->transmitter_name }}
                        {{ $message->created_at->diffForHumans() }}</p>
                </div>
            @elseif($ticketHistory->type == 'delivery')
                @php $delivery = $ticketHistory->ticketDelivery; @endphp

                <div
                    class="border rounded px-3 py-2 my-1
                    {{ $delivery->designer_id == auth()->user()->id ? 'border-success' : 'border-warning' }}">
                    <p class="m-0 "><strong>Entrega de archivos</strong></p>

                    @foreach (explode(',', $delivery->files) as $item)
                        <a href="{{ asset('/storage/items/' . $item) }}"
                            class="btn btn-sm btn-light w-25 d-flex justify-content-between" download>
                            {{ Str::limit($item, 16) }}
                            <span class="fa-fw select-all fas"></span>
                        </a>
                    @endforeach
                    <p class="m-0 " style="font-size: .8rem">
                        {{ $delivery->designer_id == auth()->user()->id ? 'Yo' : $delivery->designer_name }}
                        {{ $delivery->created_at->diffForHumans() }}</p>
                </div>
            @elseif($ticketHistory->type == 'status')
                @php $status = $ticketHistory->ticketStatusChange; @endphp
                <div class="border rounded px-3 py-2 my-1 border-success">
                    <p class="m-0 "><strong>Estado: </strong>{{ $status->status }}
                    </p>
                    <p class="m-0 " style="font-size: .8rem">
                        {{ $status->created_at->diffForHumans() }}</p>
                </div>
            @endif
        @endforeach
    </div>
</section>
