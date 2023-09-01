@extends('layouts.app')

@section('title')
    <h3>{{ $ticket->latestTicketInformation->title }}</h3>
@endsection

@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="mb-3">
                <h4 class="card-title">Informacion acerca de tu solicitud</h4>
            </div>
            <div class="mb-3">
                <p class="m-0" style="font-size: 1.2rem"><span class="font-bold">Estado: </span>{{ $statusTicket }}</p>

            </div>
            <form action="{{ route('tickets.asignarDisenador', ['ticketId' => $ticket->id]) }}" method="POST"
                id="formAssigment">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <input type="hidden" name="designer_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="designer_name" value="{{ Auth::user()->name }}">
                {{-- <input type="hidden" id="availableUsers" value="{{ json_encode($availableUsers) }}"> --}}
                <div class="">
                    @if ($ticket->designer_id == null)
                        <button type="button" class="btn btn-primary" id="assignTicketButton">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM12.75 12a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V18a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V12z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                            </svg>
                            Asignarme ticket
                        </button>
                </div>
            </form>
        @else
            <button id="reasignButton" type="button" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path
                        d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z" />
                </svg>
                Reasignar ticket
            </button>
            @endif
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                @include('layouts.components.historyTicket')
            </div>
            <div class="col-md-3">
                @if ($ticket->designer_id !== null)
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
                                        <small>{{ $delivery->created_at->diffForHumans() }}</small>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        No hay archivos disponibles
                    @endif
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

    {{-- @if ($ticket->designer_id !== null)
    @endif --}}
    {{-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </div> --}}
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
            if (status == 4) {
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

        //MODAL PARA ASIGNAR UN TICKET

        document.addEventListener('DOMContentLoaded', () => {
            const assignButton = document.getElementById('assignTicketButton');

            if (assignButton) {
                assignButton.addEventListener('click', openAssignModal);
            }

            function openAssignModal(event) {
                event.preventDefault(); // Evita que el formulario se envíe automáticamente

                Swal.fire({
                    title: 'Asignarme ticket',
                    text: '¿Estás seguro de que quieres asignarte este ticket?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    confirmButtonColor: '#25396F',
                    cancelButtonText: 'Cancelar',
                    cancelButtonColor: '#FF4D4F',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // obtener el id del formulario
                        const form = document.querySelector('#formAssigment');
                        //Submit del formulario
                        form.submit();

                    }
                });
            }
        });

        let designers = {
            @foreach ($userall as $user)
                {{ $user->id }}: '{{ $user->name }}' + ' ' + '{{ $user->lastname }}',
            @endforeach
        }

        const reassignButton = document.getElementById('reasignButton');

        reassignButton.addEventListener('click', () => {
            Swal.fire({
                title: '¿Estás seguro de reasignar el ticket?',
                icon: 'warning',
                input: 'select',
                inputOptions: designers,
                inputPlaceholder: 'Selecciona un diseñador',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                confirmButtonColor: '#25396F',
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#FF4D4F',
            }).then(async (result) => { // Utilizamos 'async' aquí para poder usar 'await'
                if (result.isConfirmed && result
                    .value) { // Asegurarse de que se haya seleccionado un diseñador
                    const selectedDesignerId = result.value;
                    const selectedDesignerName = designers[result.value];
                    const ticketId = '{{ $ticket->id }}';
                    const designerId = '{{ Auth::user()->id }}';
                    const designerName = '{{ Auth::user()->name }}';

                    try {
                        const response = await axios.post('/designer/reasignar', {
                            ticket_id: ticketId, //ID TICKET
                            designer_receives_id: selectedDesignerId, //ID SELECCION DESING
                            designer_receives: selectedDesignerName, //ID SELECCION DESING
                            designer_id: designerId, /// DESIGNER ID
                            designer_name: designerName /// DESIGNER NAME
                        });

                        if (response.data.success) {
                            Swal.fire(
                                'Reasignación exitosa',
                                'El ticket ha sido reasignado correctamente.',
                                'success'
                            );
                            // Actualizar la interfaz si es necesario
                        } else {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al reasignar el ticket.',
                                'error'
                            );
                        }
                    } catch (error) {
                        console.error('Error al hacer la solicitud:', error);
                        Swal.fire(
                            'Error',
                            'Hubo un problema al reasignar el ticket.',
                            'error'
                        );
                    }
                }
            });
        });
    </script>
@endsection
