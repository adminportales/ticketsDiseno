@extends('layouts.app')

@section('title')
    <h3>{{ $ticket->latestTicketInformation->title }}</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Informacion acerca de tu solicitud</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <section class="border-0">
                    <h5>Historial</h5>
                    <form action="{{ route('message.store') }}" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                        <div class="d-flex">
                            <div class="form-group flex-grow-1">
                                <input type="text" class="form-control" placeholder="Agrega una nota adicional"
                                    name="message">
                            </div>
                            <input type="submit" class="btn btn-sm btn-info mx-1" value="Enviar">
                        </div>
                    </form>
                    @foreach ($ticketHistories as $ticketHistory)
                        <div class="border border-primary rounded px-3 py-2">
                            @if ($ticketHistory->type == 'info')
                                @php $information = $ticketHistory->ticketInformation; @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-0"><strong>Cliente: </strong>{{ $information->customer }}
                                        </p>
                                        <p class="m-0"><strong>Tecnica: </strong>{{ $information->technique }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0"><strong>Pantone: </strong>{{ $information->pantone }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                @php $message = $ticketHistory->ticketMessage; @endphp
                                <p class="m-0">{{ $message->message }}</p>
                                <p class="m-0">{{ $message->created_at }}</p>
                            @endif
                        </div>
                    @endforeach
                    {{-- @foreach ($messages as $message)
                        <div class="border border-primary rounded px-3 py-2">
                            <p class="m-0 p-0"><small>{{ $message->message }}</small></p>
                            <p class="m-0 p-0"><small>{{ $message->created_at->diffForHumans() }}</small></p>
                        </div>
                    @endforeach

                    @foreach ($ticketInformation as $ticket)
                        <div class="border border-primary rounded px-3 py-2">
                            <li>{{ $ticket->statusTicket->status }}</li>
                            <li>{{ $ticket->customer }}</li>
                            <li>{{ $ticket->technique }}</li>
                            <li>{{ $ticket->description }}</li>
                            <li>{{ $ticket->title }}</li>
                            <li><img src="{{ asset('storage\items\1634147926.jpg') }}" alt="" width="200"></li>
                            <li><img src="{{ asset('storage\images\1.jpg') }}" alt="" width="200"></li>
                            <li>{{ $ticket->pantone }}</li>
                            <li>{{ $ticket->created_at }}</li>
                        </div>
                    @endforeach --}}
                </section>
            </div>
            <div class="col-md-3">
                <h5>Estado</h5>
                @foreach ($statuses as $status)
                    <span
                        class="{{ $ticket->status_id == $status->id ? 'text-success fw-bold' : '' }}">{{ $status->status }}</span><br>
                @endforeach
                <article>
                    <h3 align="left">Archivos</h3>
                    <ul align="left">
                        <li>Archivo.jpg</li>
                        <li>img.jpg</li>
                        <li>documento.pdf</li>
                        <li>modificación.pdf</li>
                    </ul>
                </article>
            </div>
        </div>
    </div>
@endsection
