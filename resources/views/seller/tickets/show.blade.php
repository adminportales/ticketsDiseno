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
            <div class="d-flex flex-row-reverse" style="width: 40%">
                <p class="m-0" style="font-size: 1.2rem"><span class="font-bold">Estado: </span>{{ $statusTicket }}</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                @include('layouts.components.historyTicket')
            </div>
            <div class="col-md-4">
                @if ($statusTicket !== 'Finalizado')
                    <button class="btn btn-sm btn-warning btn-block" onclick="cerrarTicket()">Cerrar Solicitud</button>
                @endif
                <h5>Entregas realizadas</h5>
                @if (count($ticketDeliveries) > 0)
                    <div class="border border-info rounded d-flex flex-column-reverse">
                        @foreach ($ticketDeliveries as $delivery)
                            <div class="item">
                                @foreach (explode(',', $delivery->files) as $item)
                                    <div class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
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
                                <p class="m-0 text-center" style="font-size: .7rem">
                                    <small>{{ $delivery->created_at }}</small>
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    No hay archivos disponibles
                @endif
            </div>
        </div>
    </div>

    @if ($ticket->latestTicketDelivery)

    <div class="d-none" id="message-initial">
        <p class="font-bold align-items-center py-1 mb-1 mx-1"> Mensaje de la ultima entrega{{ $ticket->ultimosMensajes}}</p>
        @foreach ( $ultimosMensajes as $message)
        <div class="d-flex justify-content-center align-items-center bg-light py-1 mb-1 mx-1">{{$message->message}}</div>
        @endforeach

            <p class="font-bold">Ultima entrega realizada por {{ $ticket->latestTicketDelivery->designer_name }}</p>
            @foreach (explode(',', $ticket->latestTicketDelivery->files) as $item)
                <div class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
                    <div class="name" style="width: 85%">
                        {{ Str::substr($item, 11) }}
                    </div>
                    <div class="actions d-flex justify-content-around" style="width: 15%">
                        <a href="{{ route('tickets.viewFile', ['file' => $item, 'folder' => 'deliveries']) }}"
                            target="_blank">
                            <span class="fa-eye fas"></span>
                        </a>
                        <a href="{{ asset('/storage/deliveries/' . $item) }}" download="{{ Str::substr($item, 11) }}">
                            <span class="fa-fw select-all fas"></span>
                        </a>
                    </div>
                </div>
            @endforeach
            <p class="m-0 text-center" style="font-size: .9rem">
                <small>{{ $ticket->latestTicketDelivery->created_at->diffForHumans() }}</small>
            </p>
            <div>
                @php
                    unset($ticketDeliveries[count($ticketDeliveries) - 1]);
                @endphp
                @if (count($ticketDeliveries))
                    <div id="entregasAnteriores">
                        <p class="font-bold text-sm">Entregas realizadas anteriormente</p>
                        <div class="d-flex flex-column-reverse text-sm">
                            @foreach ($ticketDeliveries as $delivery)
                                <div class="item">
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
                                    <p class="m-0 text-center" style="font-size: .7rem">
                                        <small>{{ $delivery->created_at }}</small>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
        integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets\vendors\sweetalert2\sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">

    <style>
        .items {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: 1fr;
            grid-column-gap: 0px;
            grid-row-gap: 0px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2\sweetalert2.all.min.js') }}"></script>
    <script>
        let ticket_id = '{{ $ticket->id }}'
        let status = '{{ $ticket->latestStatusChangeTicket->status_id }}'
        let messageInitial = document.querySelector("#message-initial")
        let beforeUrl = "{{ url('/tickets') }}"

        document.addEventListener('DOMContentLoaded', () => {
            if (status == 3) {
                verificar()
            }
        })

        function verificar() {
            Swal.fire({
                title: '¿El contenido esta acorde a lo solicitado?',
                html: messageInitial.innerHTML,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, es correcto',
                denyButtonText: 'Necesito una modificacion!',
                cancelButtonText: `Salir`,
                showDenyButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((result) => {
                console.log(result);
                if (result.isConfirmed) {
                    finalizar()
                } else if (result.isDenied) {
                    solicitarCambios()
                } else {
                    window.location = beforeUrl;
                }
            })
        }

        function solicitarCambios() {
            Swal.fire({
                title: '¿Que modificacion deseas?',
                input: 'textarea',
                showCancelButton: true,
                confirmButtonText: 'Enviar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((result) => {
                console.log(result)
                if (result.value == undefined) {
                    solicitarCambios()
                } else if (result.value.trim() !== "") {
                    changeStatus(4, ticket_id, result.value)
                } else {
                    solicitarCambios()
                }
                if (!result.isConfirmed) {
                    verificar()
                }
            })
        }

        function finalizar() {
            Swal.fire({
                title: 'Al continuar el ticket quedara finalizado',
                text: 'Estas seguro de continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, continuar',
                cancelButtonText: 'Cancelar',
                showDenyButton: true,
                denyButtonText: 'No, deseo modificar algo',
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    changeStatus(6, ticket_id)
                } else if (result.isDenied) {
                    solicitarCambios()
                } else {
                    verificar()
                }
            })
        }

        async function changeStatus(status, ticket, message = '') {
            try {
                let params = {
                    status: status,
                    message: message,
                    _method: "put"
                };
                let res = await axios.post(
                    `/design/update-status/${ticket}`,
                    params
                );
                let data = res.data;
                console.log(data);
                if (data.message == 'OK') {
                    Swal.fire(
                        'Excelente!',
                        `Estado: ${data.status}.`,
                        'success'
                    );
                }
            } catch (error) {
                Swal.fire(
                    'Error!',
                    'No se pudo cambiar el estado',
                    'error'
                );
            }
        }

        function cerrarTicket() {
            Swal.fire({
                title: 'Desea finalizar esta solicitud?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, continuar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    changeStatus(6, ticket_id)
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                }
            })
        }

        function verMas() {
            // const latest = document.querySelector("#entregasAnteriores")
            // latest.style.display = 'block';
            // // const opcional = document.querySelector('.opcional')
            // // opcional.classList.remove('d-none')
        }
    </script>
@endsection
