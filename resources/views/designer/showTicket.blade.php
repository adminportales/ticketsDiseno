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
                <p class="m-0" style="font-size: 1.2rem">{{ $statusTicket }}</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                @include('layouts.components.historyTicket')
            </div>
            <div class="col-md-3">
                <h5>Entregas</h5>
                <button type="button" class="boton-entregar-archivos" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Entregar <span class="fa-fw select-all fas"></span>
                </button>
                <hr>
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
                                    <small>{{ $delivery->created_at->diffForHumans() }}</small>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Entrega de archivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('ticket.delivery', ['ticket' => $ticket->id]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div id="dropzoneDelivery" class="dropzone form-control text-center"
                            style="height: auto; width: auto">
                        </div>
                        <input type="hidden" name="delivery" id="delivery" value="{{ old('delivery') }}">
                        @error('delivery')
                            {{ $message }}
                        @enderror
                        <p id="error"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
        integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets\vendors\sweetalert2\sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">

    <style>
        .pantone {
            border-radius: 50px;
            text-align: center;
            width: 50px;
            padding: 0 35px;
            margin-right: 100px;
        }

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
    <script src="{{ asset('assets/vendors/sweetalert2\sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        let beforeUrl = '{{ url('') }}'
        let ticket_id = '{{ $ticket->id }}'
        let status = '{{ $ticket->latestStatusChangeTicket->status_id }}'
        document.addEventListener('DOMContentLoaded', () => {
            if (status == 1 || status == 4) {
                let title = status == 1 ?
                    'Deseas iniciar con esta solicitud?' :
                    'Deseas realizar los ajustes de esta solicitud?'
                Swal.fire({
                    title: title,
                    text: "De no ser asi, seras enviado a la pantalla anterior!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    allowOutsideClick: false,
                    position: 'top-end',
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let statusChange = status == 1 ? 2 : 5
                        changeStatus(statusChange, ticket_id)
                    } else {
                        window.location = beforeUrl;
                    }
                })
            }
        })

        async function changeStatus(status, ticket) {
            try {
                let params = {
                    status: status,
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
                        'Esta solicitud ahora esta en proceso.',
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

        //
    </script>
@endsection
