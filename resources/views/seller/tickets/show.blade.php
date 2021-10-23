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
                    @php
                        $latestInformation = null;
                    @endphp
                    <div class="d-flex flex-column-reverse">
                        @foreach ($ticketHistories as $ticketHistory)
                            @if ($ticketHistory->type == 'info')
                                @php $information = $ticketHistory->ticketInformation; @endphp
                                <div class="border border-primary rounded px-3 py-2 my-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($latestInformation && $information->title != $latestInformation->title)
                                                <p class="m-0"><strong>Titulo:
                                                    </strong>{{ $latestInformation->title }}
                                                    <span class="fa-fw select-all fas"></span>
                                                    {{ $information->title }}
                                                </p>
                                            @elseif(!$latestInformation)
                                                <p class="m-0"><strong>Titulo:
                                                    </strong>{{ $information->title }}
                                                </p>
                                            @endif
                                            @if ($latestInformation && $information->statusTicket->status != $latestInformation->statusTicket->status)
                                                <p class="m-0"><strong>Estado:
                                                    </strong>{{ $latestInformation->statusTicket->status }} <span
                                                        class="fa-fw select-all fas"></span>
                                                    {{ $information->statusTicket->status }}
                                                </p>
                                            @elseif(!$latestInformation)
                                                <p class="m-0"><strong>Estado:
                                                    </strong>{{ $information->statusTicket->status }}
                                                </p>
                                            @endif

                                            @if ($latestInformation && $information->customer != $latestInformation->customer)
                                                <p class="m-0"><strong>Cliente:
                                                    </strong>{{ $latestInformation->customer }} <span
                                                        class="fa-fw select-all fas"></span>
                                                    {{ $information->customer }}
                                                </p>
                                            @elseif(!$latestInformation)
                                                <p class="m-0"><strong>Cliente:
                                                    </strong>{{ $information->customer }}
                                                </p>
                                            @endif

                                            @if ($latestInformation && $information->techniqueTicket->name != $latestInformation->techniqueTicket->name)
                                                <p class="m-0"><strong>Tecnica:
                                                    </strong>{{ $latestInformation->techniqueTicket->name }} <span
                                                        class="fa-fw select-all fas"></span>
                                                    {{ $information->techniqueTicket->name }}
                                                </p>
                                            @elseif(!$latestInformation)
                                                <p class="m-0"><strong>Tecnica:
                                                    </strong>{{ $information->techniqueTicket->name }}
                                                </p>
                                            @endif

                                            @if ($latestInformation && $information->pantone != $latestInformation->pantone)
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
                                            @elseif(!$latestInformation)
                                                <p class="m-0 d-inline"><strong>Color aproximado:</strong>
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
                                            @elseif(!$latestInformation)
                                                <p class="m-0"><strong>Descripción:
                                                    </strong>{{ $information->description }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                @if ($latestInformation && $information->logo != $latestInformation->logo)
                                                    <div class="col-md-12 col-sm-12">
                                                        <p class="m-0"><strong>Logo:
                                                            </strong>
                                                        </p>
                                                        <img src="{{ asset('/storage/logos/' . $latestInformation->logo) }}"
                                                            alt="" class="img-thumbnail rounded img-history">
                                                        <span class="fa-fw select-all fas"></span>
                                                        <img src="{{ asset('/storage/logos/' . $information->logo) }}"
                                                            alt="" class="img-thumbnail rounded img-history">
                                                    </div>
                                                @elseif(!$latestInformation)
                                                    <div class="col-md-6 col-sm-6">
                                                        <p class="m-0"><strong>Logo:
                                                            </strong>
                                                        </p>
                                                        <img src="{{ asset('/storage/logos/' . $information->logo) }}"
                                                            alt="" class="img-thumbnail rounded img-history">
                                                    </div>
                                                @endif

                                                @if ($latestInformation && $information->product != $latestInformation->product)
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
                                                @elseif(!$latestInformation)
                                                    <div class="col-md-6 col-sm-6">
                                                        <p class="m-0"><strong>Producto:
                                                            </strong>
                                                        </p>
                                                        <img src="{{ asset('/storage/products/' . $information->product) }}"
                                                            alt="" class="img-thumbnail rounded img-history">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="m-0"><strong>Items: </strong></p>
                                            <div class="d-flex flex-wrap">
                                                @foreach (explode(',', $information->items) as $item)
                                                    <div class="img-items ">
                                                        <img src="{{ asset('/storage/items/' . $item) }}" alt=""
                                                            class="img-thumbnail rounded">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <p class="m-0" style="font-size: .8rem">
                                            {{ $information->modifier_id == auth()->user()->id ? 'Yo' : $information->modifier_name }}
                                            {{ $information->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                @php $latestInformation = $information; @endphp
                            @else
                                @php $message = $ticketHistory->ticketMessage; @endphp
                                <div
                                    class="border rounded px-3 py-2 my-1
                                {{ $message->transmitter_id == auth()->user()->id ? 'border-success' : 'border-warning' }}">
                                    <p class="m-0 ">{{ $message->message }}</p>
                                    <p class="m-0 " style="font-size: .8rem">
                                        {{ $message->transmitter_id == auth()->user()->id ? 'Yo' : $message->transmitter_name }}
                                        {{ $message->created_at->diffForHumans() }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">

    <style>
        .pantone {
            border-radius: 50px;
            text-align: center;
            width: 50px;
            padding: 0 35px;
            margin-right: 100px;
        }

        .img-items {
            flex-basis: 100%;
        }

        @media(min-width: 480px) {
            .img-items {
                flex-basis: 50%;
            }
        }

        @media(min-width: 660px) {
            .img-items {
                flex-basis: 25%;
            }
        }

        @media(min-width: 768px) {
            .img-history {
                max-height: 130px;
            }

            .img-items {
                flex-basis: 20%;
            }
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
@endsection
