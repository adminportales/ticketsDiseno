@extends('layouts.app')

@section('title')
    <h3>{{ $ticket->latestTicketInformation->title }}</h3>
@endsection

@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="titulo">
                <h4 class="card-title">Informacion acerca de tu solicitud</h4>
            </div>
            <div class="estado">
                @foreach ($statuses as $status)
                    <small
                        class="{{ $statusTicket == $status->id ? 'text-success fw-bold' : '' }}">{{ $status->status }}</small>
                @endforeach
            </div>
        </div>
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
                        @if ($ticketHistory->type == 'info')
                            @php $information = $ticketHistory->ticketInformation; @endphp
                            <div class="border border-primary rounded px-3 py-2 my-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="m-0"><strong>Estado:
                                            </strong>{{ $information->statusTicket->status }}
                                        </p>
                                        <p class="m-0"><strong>Cliente:
                                            </strong>{{ $information->customer }}
                                        </p>
                                        <p class="m-0"><strong>Tecnica:
                                            </strong>{{ $information->technique }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="m-0 d-inline"><strong>Color aproximado:</strong>
                                            <small class="m-0 pantone"
                                                style="height: 10px; background-color: {{ $information->pantone }}; color: {{ $information->pantone }}">.</small>
                                            <small style="display: inline-block"> {{ $information->pantone }} </small>
                                        </p>
                                        <p class="m-0"><strong>Descripción:
                                            </strong>{{ $information->description }}
                                        </p>
                                    </div>
                                    <p class="m-0" style="font-size: .7rem">
                                        <small>{{ $information->created_at->diffForHumans() }}</small>
                                    </p>
                                </div>
                            </div>
                        @else
                            @php $message = $ticketHistory->ticketMessage; @endphp
                            <div class="border border-warning rounded px-3 py-2 my-1">
                                <p class="m-0">{{ $message->message }}</p>
                                <p class="m-0" style="font-size: .7rem">
                                    <small>{{ $message->created_at->diffForHumans() }}</small>
                                </p>
                            </div>
                        @endif
                    @endforeach
                </section>
            </div>
            <div class="col-md-3">
                <h5>Entregas</h5>
                <ul>
                    <li>Archivo.jpg</li>
                    <li>img.jpg</li>
                    <li>documento.pdf</li>
                    <li>modificación.pdf</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .pantone {
            border-radius: 50px;
            text-align: center;
            width: 50px;
            padding: 0 35px;
            margin-right: 100px;
        }

    </style>
@endsection
