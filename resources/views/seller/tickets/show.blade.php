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
                                @if ($delivery->active == true)
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
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    No hay archivos disponibles
                @endif
            </div>
        </div>
    </div>

    @if ($ticket->latestTicketDelivery && $ticket->status_id !== 8)
        <div class="modal fade" id="lastDelivery" data-bs-backdrop="false" tabindex="-1"
            aria-labelledby="lastDeliveryLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl shadow-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="lastDeliveryLabel">¿El contenido esta acorde a lo
                            solicitado?</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">

                                <p class="font-bold">Ultima entrega realizada por
                                    {{ $ticket->latestTicketDelivery->designer_name }}
                                </p>
                                @if ($delivery->active == true)
                                    @foreach (explode(',', $ticket->latestTicketDelivery->files) as $item)
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
                                    <p class="m-0 text-center" style="font-size: .9rem">
                                        <small>{{ $ticket->latestTicketDelivery->created_at->diffForHumans() }}</small>
                                    </p>
                                @else
                                    <p>Ultima entrega cancelada</p>
                                @endif
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

                                                        @if ($delivery->active == true)
                                                            @foreach (explode(',', $delivery->files) as $item)
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center bg-light py-1 mb-1 mx-1">
                                                                    <div class="name" style="width: 85%">
                                                                        {{ Str::substr($item, 11) }}
                                                                    </div>
                                                                    <div class="actions d-flex justify-content-around"
                                                                        style="width: 15%">
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
                                                        @else
                                                            <p>No hay entregas realizadas anteriormente</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="font-bold">Ultimos Mensajes</p>
                                <div class="d-flex flex-column overflow-auto" style="max-height: 400px">
                                    @php
                                        $conut = 0;
                                    @endphp
                                    @foreach ($ticketHistories as $ticketHistory)
                                        @if ($ticketHistory->type == 'message')
                                            @php $message = $ticketHistory->ticketMessage; @endphp
                                            <li
                                                class="list-group-item {{ $message->transmitter_id == auth()->user()->id ? 'text-end' : '' }}">
                                                <p class="m-0 ">{{ $message->message }}</p>
                                                <p class="m-0 " style="font-size: .8rem">
                                                    {{ $message->transmitter_id == auth()->user()->id ? 'Yo' : $message->transmitter_name }}
                                                    {{ $message->created_at->diffForHumans() }}</p>
                                            </li>
                                            @php
                                                $conut++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if ($conut == 0)
                                        <p class="text-center">No hay mensajes</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="finalizar()">Correcto</button>
                        <button type="button" class="btn btn-primary" onclick="solicitarCambios()">Necesito una
                            modificacion</button>
                        <button type="button" class="btn btn-secondary"
                            onclick="window.location = beforeUrl;">Salir</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="requestChange" data-bs-backdrop="false" tabindex="-1" aria-labelledby="requestChangeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg shadow-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="requestChangeLabel">¿Que modificacion deseas?</h5>
                </div>
                <div class="modal-body">
                    {{-- Text Area para las modificaciones --}}
                    <textarea name="message" id="message" class="form-control" placeholder="Mensaje"></textarea>
                    <br>
                    {{-- Campo para subir archovos --}}
                    <p class="m-0">Archivos Adicionales (Opcional)</p>
                    <div class="dropzone text-center" id="dropzoneItemsModificacion"></div>
                    {{-- Input de Items --}}
                    <input type="hidden" name="items" id="items" class="form-control" placeholder="Item">
                    <p id="error"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="verificar()">Cancelar</button>
                    @if ($ticket->status_id == 9)
                        <button id="sendButton" type="button" class="btn btn-success"
                            onclick="changeStatus(11, {{ $ticket->id }})">Enviar</button>
                    @else
                        <button id="sendButton" type="button" class="btn btn-success"
                            onclick="changeStatus(4, {{ $ticket->id }})">Enviar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="finallyTicket" data-bs-backdrop="false" tabindex="-1"
        aria-labelledby="finallyTicketLabel" aria-hidden="true">
        <div class="modal-dialog modal-md shadow-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="finallyTicketLabel">
                    </h5>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">Estas seguro de continuar?</h6>
                    <br>
                    @if ($ticket->status_id == 9)
                        <button type="button" class="btn btn-secondary" onclick="cerrarTicket()">Finalizar
                            ticket</button>
                        <button type="button" class="btn btn-success" onclick="solicitarCambios()">No, deseo modificar
                            artes</button>
                        <button type="button" class="btn btn-success" onclick="verificar()">Cancelar</button>
                    @else
                        <button type="button" class="btn btn-secondary" onclick="finalizarTicket()">Si,
                            solicitar artes</button>
                        <button type="button" class="btn btn-success" onclick="solicitarCambios()">No, deseo modificar
                            algo</button>
                        <button type="button" class="btn btn-success" onclick="verificar()">Cancelar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para ingresar mensaje -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Ingresar mensaje (Opcional)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="messageInput" placeholder="Ingrese su mensaje aquí">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="enviarMensaje()">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal para encuesta de satisfaccion --}}
    <div class="modal fade" id="finalizarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="evaluationForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Encuesta de Evaluación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="question" data-question="1">
                                <p class="question-text">¿Cómo calificarías el trabajo y el servicio brindado?</p>
                                <div class="row">
                                    <div class="col">
                                        <div class="emoji-rating text-center" data-rating="mal">
                                            <input type="checkbox" class="btn-check emoji-checkbox"
                                                id="btn-check-outlined" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btn-check-outlined">
                                                <div class="emoji-rating text-center" data-rating="mal">&#128577;
                                                </div>
                                                <p>Mal</p>
                                            </label><br>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="emoji-rating text-center" data-rating="neutral">
                                            <input type="checkbox" class="btn-check emoji-checkbox"
                                                id="btn-check-outlined2" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btn-check-outlined2">
                                                <div class="emoji-rating text-center" data-rating="neutral">&#128528;
                                                </div>
                                                <p>Neutral</p>
                                            </label><br>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="emoji-rating text-center" data-rating="bien">
                                            <input type="checkbox" class="btn-check emoji-checkbox"
                                                id="btn-check-outlined3" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="btn-check-outlined3">
                                                <div class="emoji-rating text-center" data-rating="bien">&#128578;
                                                </div>
                                                <p>Bien</p>
                                            </label><br>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="respuesta_1" id="respuesta_1">
                                <div class="mt-1">
                                    <p>Comentario(Opcional)</p>
                                    <input type="text" name="comentario_1" id="comentario_1">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3" id="submit-btn">Enviar</button>
                        </div>
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
        .items {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: 1fr;
            grid-column-gap: 0px;
            grid-row-gap: 0px;
        }

        a:hover {
            background-color: gold;
        }

        .blue:focus {
            outline: 2px solid black;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2\sweetalert2.all.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.emoji-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxes.forEach(cb => {
                            if (cb !== this) {
                                cb.checked = false;
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        let ticket_id = '{{ $ticket->id }}'
        let status = '{{ $ticket->latestStatusChangeTicket->status_id }}'
        let messageInitial = document.querySelector("#message-initial")
        let beforeUrl = "{{ url('/tickets') }}"

        document.addEventListener('DOMContentLoaded', () => {
            if (status == 3 || status == 8 || status == 9) {
                verificar()
            }
        })

        function verificar() {
            $('#lastDelivery').modal('show')
            $('#requestChange').modal('hide');
            $('#finallyTicket').modal('hide');
        }

        function solicitarCambios() {
            $('#lastDelivery').modal('hide');
            $('#requestChange').modal('show');
            $('#finallyTicket').modal('hide');
        }

        function finalizar() {
            $('#lastDelivery').modal('hide');
            $('#requestChange').modal('hide');
            $('#finallyTicket').modal('show');
        }

        async function changeStatus(status, ticket) {
            // Leer el mensaje y los items
            let message = document.querySelector("#message").value
            let images = document.querySelector("#items").value
            if ([message].includes('') && status != 6 && status != 8) {
                Swal.fire(
                    'Error!',
                    'El mensaje no puede estar vacio',
                    'error'
                );
                return
            }
            try {
                let sendButton = document.getElementById('sendButton');
                sendButton.disabled = true; // Deshabilitar el botón
                let params = {
                    status,
                    message,
                    images,
                    _method: "put"
                };
                let res = await axios.post(
                    `/design/update-status/${ticket}`,
                    params
                );
                let data = res.data;
                if (data.message == 'OK') {
                    Swal.fire(
                        'Excelente!',
                        `Estado: ${data.status}.`,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                    // setTimeout(() => {
                    //     /*    location.reload(); */
                    // }, 300);
                }
            } catch (error) {
                Swal.fire(
                    'Error!',
                    'No se pudo cambiar el estado',
                    'error'
                );
            } finally {
                sendButton.disabled = false; // Habilitar el botón después de que se complete la solicitud
            }
        }

        function finalizarTicket() {
            $('#messageModal').modal('show');
        }

        function enviarMensaje() {
            var mensaje = $('#messageInput').val();
            // Aquí puedes realizar cualquier acción con el mensaje, como enviarlo al servidor
            console.log('Mensaje ingresado:', mensaje);
            $.ajax({
                url: '/message', // Ruta de tu controlador de mensajes
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Agrega el token CSRF para protección contra CSRF
                    message: mensaje,
                    ticket_id: '{{ $ticket->id }}' // Si $ticket->id no está disponible aquí, asegúrate de obtenerlo de alguna manera
                },
                success: function(response) {
                    console.log(response);
                    $('#messageModal').modal('hide');
                    // location.reload();
                },
                error: function(xhr, status, error) {
                    // Manejar errores (opcional)
                    console.error(xhr.responseText);
                }
            });
            // Cambiar el status_id a 8
            changeStatus(8, ticket_id);

            // Recargar la página después de un breve retraso (opcional)
            setTimeout(() => {
                location.reload();
            }, 300);

            // Cerrar el modal
            $('#messageModal').modal('hide');
        }

        /*   function finalizarTicket() {
                    Swal.fire({
                        title: 'Desea Solicitar artes?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            changeStatus(8, ticket_id)
                            setTimeout(() => {
                                location.reload();
                            }, 300);
                        }
                    })
                }
         */
        function cerrarTicket() {
            Swal.fire({
                title: 'Desea finalizar el ticket?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result?.isConfirmed || result?.isConfirmed == 'true') {
                    var myModal = new bootstrap.Modal(document.getElementById('finalizarModal'), {
                        keyboard: false
                    });
                    myModal.show();

                }

            })
        }


        document.getElementById('evaluationForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var form = event.target;
            var formData = new FormData(form);

            var formDataObject = {};
            formData.forEach((value, key) => {
                formDataObject[key] = value;
            });

            handleEvaluationForm(formDataObject, ticket_id);
        })

        async function handleEvaluationForm(forData, ticket_id) {
            try {
                let params = {
                    comentario_1: forData.comentario_1,
                    pregunta: forData.respuesta_1.split(':')[0],
                    respuesta_1: forData.respuesta_1.split(':')[1],
                    ticket_id: ticket_id,
                };
                console.log('params', params);
                let res = await axios.post(
                    `/satisfaccion`,
                    params
                );
                console.log('res', res);
                let data = res.data;
                if (data.message == 'OK') {
                    changeStatus(6, ticket_id);

                    Swal.fire(
                        'Excelente!',
                        'Se cambio el estado correctamente',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                }
            } catch (error) {
                console.log('error', error);
                Swal.fire(
                    'Error!',
                    'No se pudo cambiar el estado',
                    'error'
                );
            }

        }

        function verMas() {}
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emojis = document.querySelectorAll('.emoji-rating');

            emojis.forEach(emoji => {
                emoji.addEventListener('click', function() {
                    // Remover la clase 'selected' de todos los emojis en la misma pregunta
                    const question = this.closest('.question');
                    const emojisInQuestion = question.querySelectorAll('.emoji-rating');
                    emojisInQuestion.forEach(e => e.classList.remove('selected'));

                    // Agregar la clase 'selected' al emoji clicado
                    this.classList.add('selected');

                    // Obtener el número de la pregunta, la calificación seleccionada y el texto de la pregunta
                    const questionNumber = question.getAttribute('data-question');
                    const rating = this.getAttribute('data-rating');
                    const questionText = question.querySelector('.question-text').textContent;

                    // Actualizar el valor del campo oculto correspondiente a la pregunta
                    document.getElementById('respuesta_' + questionNumber).value = questionText +
                        ': ' + rating;
                });
            });
        });
    </script>
@endsection
