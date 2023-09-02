<div>
    <div class="form-group m-0">
        @if ($status_reassigned)
            @if ($status_reassigned->status == 'En proceso de traspaso')
                @if ($status_reassigned->designer_received_id == auth()->user()->id)
                    <button onclick="responderTicket()" class="btn btn-primary btn-sm">Responder</button>
                @else
                    <div class="btn info">En Proceso de Traspaso</div>
                @endif
            @else
                @if ($ticket->designer_id == auth()->user()->id)
                    <button onclick="reasignarTicket()" class="btn btn-primary btn-sm">Reasignar</button>
                @endif
            @endif
        @else
            @if ($ticket->designer_id == auth()->user()->id)
                <button onclick="reasignarTicket()" class="btn btn-primary btn-sm">Reasignar</button>
            @endif
        @endif
    </div>
    <script>
        function reasignarTicket() {
            let designers = @json($users->pluck('name', 'id'));
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
            }).then(async (result) => {
                if (result.isConfirmed && result.value) {
                    const selectedDesignerId = result.value;
                    let response = @this.reassignTicket(selectedDesignerId);
                    response.then(r => {
                        if (r.message == 'OK') {
                            Swal.fire(
                                'En Proceso de Traspaso!',
                                'En espera de que el diseñador acepte el ticket.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                '¡Error!',
                                'El ticket no pudo ser reasignado.',
                                'error'
                            );
                        }
                    }).error(e => {
                        Swal.fire(
                            '¡Error!',
                            'El ticket no pudo ser reasignado.',
                            'error'
                        );
                    })
                }
            });
        }

        function responderTicket() {
            // Swal con aceptar, cancelar y salir
            Swal.fire({
                title: '¿Estás seguro de aceptar el ticket?',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#25396F',
                showDenyButton: true,
                denyButtonText: 'Rechazar',
                denyButtonColor: '#FF4D4F',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let response = @this.acceptReassign();
                    response.then(r => {
                        if (r.message == 'OK') {
                            Swal.fire(
                                'Ticket Aceptado!',
                                '',
                                'success'
                            );

                            window.location.href = "/designer/ticketShow/" + r.ticket_id;
                        } else {
                            Swal.fire(
                                '¡Error!',
                                'El ticket no pudo ser reasignado.',
                                'error'
                            );
                        }
                    }).error(e => {
                        Swal.fire(
                            '¡Error!',
                            'El ticket no pudo ser reasignado.',
                            'error'
                        );
                    })
                } else if (result.isDenied) {
                    let response = @this.cancelReassign();
                    response.then(r => {
                        if (r.message == 'OK') {
                            Swal.fire(
                                'Ticket Rechazado!',
                                '',
                                'success'
                            );
                            // Redireccionar al home
                            window.location = '{{ url('') }}';
                        } else {
                            Swal.fire(
                                '¡Error!',
                                'El ticket no pudo ser rechazado.',
                                'error'
                            );
                        }
                    }).error(e => {
                        Swal.fire(
                            '¡Error!',
                            'El ticket no pudo ser rechazado.',
                            'error'
                        );
                    })
                }
                console.log(result);
            });
        }
    </script>
</div>
