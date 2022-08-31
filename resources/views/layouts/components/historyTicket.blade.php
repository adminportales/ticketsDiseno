<section class="border-0 row">
    <div class="col-md-8">
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
        @permission('create-ticket')
            <p class="m-0"><strong>Asignado a:
                </strong>{{ $ticket->designer_name }}
            </p>
        @endpermission
        @role('sales_assistant')
            <p class="m-0">
                <strong>Ejecutivo:
                </strong>{{ $ticket->seller_name }}
            </p>
        @endrole
        <hr>
        @if ($ticket->latestTicketInformation->customer)
            <p class="m-0"><strong>Cliente:
                </strong>{{ $ticket->latestTicketInformation->customer }}
            </p>
        @endif
        @if ($ticket->latestTicketInformation->techniqueTicket)
            <p class="m-0"><strong>Tecnica: </strong>
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
            <p class="m-0"><strong>Posicion:
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
        <p class="m-0"><strong>Descripción:
            </strong>{!! $ticket->latestTicketInformation->description !!}
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
            @foreach (explode(',', $ticket->latestTicketInformation->logo) as $item)
                <a href="{{ asset('/storage/logos/' . $item) }}"
                    class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                    download="{{ Str::substr($item, 11) }}">
                    {{ Str::limit(Str::substr($item, 11), 20) }}
                    <span class="fa-fw select-all fas"></span>
                </a>
            @endforeach
        @endif
        @if ($ticket->latestTicketInformation->product)
            <p class="m-0"><strong>Producto:</strong>
            </p>
            @foreach (explode(',', $ticket->latestTicketInformation->product) as $item)
                <a href="{{ asset('/storage/products/' . $item) }}"
                    class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                    download="{{ Str::substr($item, 11) }}">
                    {{ Str::limit(Str::substr($item, 11), 20) }}
                    <span class="fa-fw select-all fas"></span>
                </a>
            @endforeach
        @endif
        @if ($ticket->latestTicketInformation->items)
            <p class="m-0"><strong>Items:</strong></p>
            @foreach (explode(',', $ticket->latestTicketInformation->items) as $item)
                <a href="{{ asset('/storage/items/' . $item) }}"
                    class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                    download="{{ Str::substr($item, 11) }}">
                    {{ Str::limit(Str::substr($item, 11), 20) }}
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
    <div class="">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                    type="button" role="tab" aria-controls="home" aria-selected="true">Mensajes</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                    role="tab" aria-controls="profile" aria-selected="false">Proceso</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                    role="tab" aria-controls="contact" aria-selected="false">Modificaciones</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                    role="tab" aria-controls="info" aria-selected="false">Entregas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                    role="tab" aria-controls="all" aria-selected="false">Historial</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <ul class="list-group d-flex flex-column-reverse">
                    @foreach ($ticketHistories as $ticketHistory)
                        @if ($ticketHistory->type == 'message')
                            @php $message = $ticketHistory->ticketMessage; @endphp
                            {{-- <li class="list-group-item"> --}}
                            <li
                                class="list-group-item {{ $message->transmitter_id == auth()->user()->id ? 'text-end' : '' }}">
                                <p class="m-0 ">{{ $message->message }}</p>
                                <p class="m-0 " style="font-size: .8rem">
                                    {{ $message->transmitter_id == auth()->user()->id ? 'Yo' : $message->transmitter_name }}
                                    {{ $message->created_at->diffForHumans() }}</p>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <ul class="list-group d-flex flex-column-reverse">
                    @foreach ($ticketHistories as $ticketHistory)
                        @if ($ticketHistory->type == 'status')
                            @php $status = $ticketHistory->ticketStatusChange; @endphp
                            <li class="list-group-item">
                                <p class="m-0 ">{{ $status->status }}
                                </p>
                                <p class="m-0 " style="font-size: .8rem">
                                    {{ $status->created_at->diffForHumans() }}</p>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <ul class="list-group d-flex flex-column-reverse">
                    @php
                        $latestInformation = null;
                    @endphp
                    @foreach ($ticketHistories as $ticketHistory)
                        @if ($ticketHistory->type == 'info')
                            @php $information = $ticketHistory->ticketInformation; @endphp
                            <li class="list-group-item">
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
                                            @if ($information->position)
                                                @if ($information->position != $latestInformation->position)
                                                    <p class="m-0"><strong>Posicion del logo:
                                                        </strong>{{ $latestInformation->position }} <span
                                                            class="fa-fw select-all fas"></span>
                                                        {{ $information->position }}
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
                                            @if ($information->pantone)
                                                @if ($information->pantone != $latestInformation->pantone)
                                                    <p class="m-0">
                                                        <strong>Color aproximado:</strong>
                                                        <small style="display: inline-block">
                                                            {{ $latestInformation->pantone }} </small> <span
                                                            class="fa-fw select-all fas"></span>
                                                        <small style="display: inline-block">
                                                            {{ $information->pantone }}
                                                        </small>
                                                    </p>
                                                @endif
                                            @endif
                                            @if ($information->description != $latestInformation->description)
                                                <strong>Descripción:
                                                </strong>
                                                {!! $latestInformation->description !!}
                                                <span class="fa-fw select-all fas"></span>
                                                {!! $information->description !!}
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                @if ($information->logo)
                                                    @php
                                                        $diferencias = array_diff(explode(',', $information->logo), explode(',', $latestInformation->logo));
                                                    @endphp
                                                    @if (!empty($diferencias))
                                                        <p class="m-0"><strong>Logos: </strong></p>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $latestInformation->logo) as $item)
                                                                    <a href="{{ asset('/storage/logos/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="fa-fw select-all fas"></span>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $information->logo) as $item)
                                                                    <a href="{{ asset('/storage/logos/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if ($information->product)
                                                    @php
                                                        $diferencias = array_diff(explode(',', $information->product), explode(',', $latestInformation->product));
                                                    @endphp
                                                    @if (!empty($diferencias))
                                                        <p class="m-0"><strong>Productos: </strong></p>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $latestInformation->product) as $item)
                                                                    <a href="{{ asset('/storage/products/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="fa-fw select-all fas"></span>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $information->product) as $item)
                                                                    <a href="{{ asset('/storage/products/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        @if ($information->items)
                                            @php
                                                $diferencias = array_diff(explode(',', $information->items), explode(',', $latestInformation->items));
                                            @endphp
                                            @if (!empty($diferencias))
                                                <p class="m-0"><strong>Items: </strong></p>
                                                <div class="col-md-5">
                                                    <div class="d-flex flex-wrap">
                                                        @foreach (explode(',', $latestInformation->items) as $item)
                                                            <a href="{{ asset('/storage/items/' . $item) }}"
                                                                class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                download="{{ Str::substr($item, 11) }}">
                                                                {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                <span class="fa-fw select-all fas"></span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="fa-fw select-all fas"></span>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="d-flex flex-wrap">
                                                        @foreach (explode(',', $information->items) as $item)
                                                            <a href="{{ asset('/storage/items/' . $item) }}"
                                                                class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                download="{{ Str::substr($item, 11) }}">
                                                                {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                <span class="fa-fw select-all fas"></span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
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
                            </li>
                            @php $latestInformation = $information; @endphp
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                <ul class="list-group d-flex flex-column-reverse">
                    @foreach ($ticketHistories as $ticketHistory)
                        @if ($ticketHistory->type == 'delivery')
                            @php $delivery = $ticketHistory->ticketDelivery; @endphp
                            <li class="list-group-item">
                                <p class="m-0 "><strong>Entrega de archivos</strong></p>
                                @foreach (explode(',', $delivery->files) as $item)
                                    <div
                                        class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
                                        <div class="name" style="width: 85%">
                                            {{ Str::substr($item, 11) }}
                                        </div>
                                        <div class="actions d-flex justify-content-around" style="width: 15%">
                                            <a href="{{ route('tickets.viewFile', ['file' => $item, 'folder' => 'deliveries']) }}"
                                                target="_blank">
                                                <span class="fa-eye fas"></span>
                                            </a>
                                            <a href="{{ asset('/storage/deliveries/' . $item) }}"
                                                download="{{ Str::substr($item, 11) }}">
                                                <span class="fa-fw select-all fas"></span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                <p class="m-0 " style="font-size: .8rem">
                                    {{ $delivery->designer_id == auth()->user()->id ? 'Yo' : $delivery->designer_name }}
                                    {{ $delivery->created_at->diffForHumans() }}</p>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                <ul class="list-group d-flex flex-column-reverse">
                    @php
                        $latestInformation = null;
                    @endphp
                    @foreach ($ticketHistories as $ticketHistory)
                        @if ($ticketHistory->type == 'info')
                            @php $information = $ticketHistory->ticketInformation; @endphp
                            <li class="list-group-item">
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
                                            @if ($information->position)
                                                @if ($information->position != $latestInformation->position)
                                                    <p class="m-0"><strong>Posicion del logo:
                                                        </strong>{{ $latestInformation->position }} <span
                                                            class="fa-fw select-all fas"></span>
                                                        {{ $information->position }}
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
                                            @if ($information->pantone)
                                                @if ($information->pantone != $latestInformation->pantone)
                                                    <p class="m-0">
                                                        <strong>Pantone:</strong>
                                                        <small style="display: inline-block">
                                                            {{ $latestInformation->pantone }} </small>
                                                        <span class="fa-fw select-all fas"></span>
                                                        <small style="display: inline-block">
                                                            {{ $information->pantone }}
                                                        </small>
                                                    </p>
                                                @endif
                                            @endif
                                            @if ($information->link)
                                                @if ($information->link != $latestInformation->link)
                                                    <p class="m-0">
                                                        <strong>Link:</strong>
                                                        <small style="display: inline-block">
                                                            {{ $latestInformation->link }} </small>
                                                        <span class="fa-fw select-all fas"></span>
                                                        <small style="display: inline-block">
                                                            {{ $information->link }}
                                                        </small>
                                                    </p>
                                                @endif
                                            @endif
                                            @if ($information->description != $latestInformation->description)
                                                <strong>Descripción:
                                                </strong>
                                                {!! $latestInformation->description !!}
                                                <span class="fa-fw select-all fas"></span>
                                                {!! $information->description !!}
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                @if ($information->logo)
                                                    @php
                                                        $diferencias = array_diff(explode(',', $information->logo), explode(',', $latestInformation->logo));
                                                    @endphp
                                                    @if (!empty($diferencias))
                                                        <p class="m-0"><strong>Logos: </strong></p>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $latestInformation->logo) as $item)
                                                                    <a href="{{ asset('/storage/logos/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="fa-fw select-all fas"></span>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $information->logo) as $item)
                                                                    <a href="{{ asset('/storage/logos/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if ($information->product)
                                                    @php
                                                        $diferencias = array_diff(explode(',', $information->product), explode(',', $latestInformation->product));
                                                    @endphp
                                                    @if (!empty($diferencias))
                                                        <p class="m-0"><strong>Productos: </strong></p>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $latestInformation->product) as $item)
                                                                    <a href="{{ asset('/storage/products/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="fa-fw select-all fas"></span>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="d-flex flex-wrap">
                                                                @foreach (explode(',', $information->product) as $item)
                                                                    <a href="{{ asset('/storage/products/' . $item) }}"
                                                                        class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                        download="{{ Str::substr($item, 11) }}">
                                                                        {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                        <span class="fa-fw select-all fas"></span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        @if ($information->items)
                                            @php
                                                $diferencias = array_diff(explode(',', $information->items), explode(',', $latestInformation->items));
                                            @endphp
                                            @if (!empty($diferencias))
                                                <p class="m-0"><strong>Items: </strong></p>
                                                <div class="col-md-5">
                                                    <div class="d-flex flex-wrap">
                                                        @foreach (explode(',', $latestInformation->items) as $item)
                                                            <a href="{{ asset('/storage/items/' . $item) }}"
                                                                class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                download="{{ Str::substr($item, 11) }}">
                                                                {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                <span class="fa-fw select-all fas"></span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <span class="fa-fw select-all fas"></span>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="d-flex flex-wrap">
                                                        @foreach (explode(',', $information->items) as $item)
                                                            <a href="{{ asset('/storage/items/' . $item) }}"
                                                                class="btn btn-sm btn-light w-100 d-flex justify-content-between"
                                                                download="{{ Str::substr($item, 11) }}">
                                                                {{ Str::limit(Str::substr($item, 11), 20) }}
                                                                <span class="fa-fw select-all fas"></span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
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
                            </li>
                            @php $latestInformation = $information; @endphp
                        @elseif ($ticketHistory->type == 'message')
                            @php $message = $ticketHistory->ticketMessage; @endphp
                            {{-- <li class="list-group-item"> --}}
                            <li
                                class="list-group-item {{ $message->transmitter_id == auth()->user()->id ? 'text-end' : '' }}">
                                <p class="m-0 ">{{ $message->message }}</p>
                                <p class="m-0 " style="font-size: .8rem">
                                    {{ $message->transmitter_id == auth()->user()->id ? 'Yo' : $message->transmitter_name }}
                                    {{ $message->created_at->diffForHumans() }}</p>
                            </li>
                        @elseif($ticketHistory->type == 'delivery')
                            @php $delivery = $ticketHistory->ticketDelivery; @endphp
                            <li class="list-group-item">
                                <p class="m-0 "><strong>Entrega de archivos</strong></p>
                                @foreach (explode(',', $delivery->files) as $item)
                                    <div
                                        class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
                                        <div class="name" style="width: 85%">
                                            {{ Str::substr($item, 11) }}
                                        </div>
                                        <div class="actions d-flex justify-content-around" style="width: 15%">
                                            <a href="{{ route('tickets.viewFile', ['file' => $item, 'folder' => 'deliveries']) }}"
                                                target="_blank">
                                                <span class="fa-eye fas"></span>
                                            </a>
                                            <a href="{{ asset('/storage/deliveries/' . $item) }}"
                                                download="{{ Str::substr($item, 11) }}">
                                                <span class="fa-fw select-all fas"></span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                <p class="m-0 " style="font-size: .8rem">
                                    {{ $delivery->designer_id == auth()->user()->id ? 'Yo' : $delivery->designer_name }}
                                    {{ $delivery->created_at->diffForHumans() }}</p>
                            </li>
                        @elseif($ticketHistory->type == 'status')
                            @php $status = $ticketHistory->ticketStatusChange; @endphp
                            <li class="list-group-item">
                                @php $color = ''; @endphp
                                @switch($status->status)
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
                                <div class="p-1 m-0 alert {{ $color }}">
                                    {{ $status->status }}</div>
                                <p class="m-0 " style="font-size: .8rem">
                                    {{ $status->created_at->diffForHumans() }}</p>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
