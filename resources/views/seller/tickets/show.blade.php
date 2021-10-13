@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <div class="row">
            <div class="col-md-3 my-5">
                @include('seller.menu')
            </div>
            <div class="col-md-9">
                <h1>Atender ticket</h1>
                <h3>Atender ticket</h3>
                <h2>Tomas Vendedor</h2>
                <br>
                <button>Nuevo</button>
                <button>En proceso</button>
                <button>Entregado</button>
                <button>Ajustes</button>
                <button>Finalizado</button>

                <section class="d-flex">
                    <article>
                        <h3 align="left">Chat</h3>
                        <p align="left">
                            <b>Edwin Samuel 13/10/2021 09:37am</b><br />
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. <br />
                            Autem quibusdam hic sed laudantium, esse necessitatibus recusandae in. <br />

                        </p>
                        <p align="left">
                            <b>Tomas 13/10/2021 10:00am</b><br />
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. <br />
                            Autem quibusdam hic sed laudantium, esse necessitatibus recusandae in. <br />

                        </p>
                        <p align="left">
                            <b>Edwin Samuel 13/10/2021 10:05am</b><br />
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. <br />
                            Autem quibusdam hic sed laudantium, esse necessitatibus recusandae in. <br />

                        </p>
                        <textarea rows="" cols="" class="form-control w-50" name="description"></textarea>

                        <button>Enviar mensaje</button>
                        <button>Cerrar ticket</button>
                    </article>

                    <article>
                        <h3 align="left">Archivos</h3>
                        <ul align="left">
                            <li>Archivo.jpg</li>
                            <li>img.jpg</li>
                            <li>documento.pdf</li>
                            <li>modificación.pdf</li>
                        </ul>

                        <button> Enviar archivo</button>
                    </article>

                    <article>
                        <h3 align="left">Información del ticket</h3>
                        <ul align="left">
                            @foreach ($ticketInformation as $ticket)
                                <li>{{ $loop->iteration }}</li>
                                <li>{{$ticket->statusTicket->status}}</li>
                                <li>{{$ticket->customer}}</li>
                                <li>{{$ticket->technique}}</li>
                                <li>{{$ticket->description}}</li>
                                <li>{{$ticket->title}}</li>
                                <li><img src="{{ asset('storage').'/'.$ticket->logo}}" alt="" width="200"> </li>
                                <li><img src="{{ asset ('storage').'/'.$ticket->product}}" alt="" width="200"></li>
                                <li>{{$ticket->pantone}}</li>
                                <li>{{$ticket->created_at}}s</li>
                                <li>{{$ticket->updated_at}}s</li>
                            @endforeach
                        </ul>
                    </article>

                </section>

            </div>
        </div>
    </div>
@endsection
