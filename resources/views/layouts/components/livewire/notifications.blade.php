<div>
    @if ($active)
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <svg class="bi bell" fill="currentColor">
                <use xlink:href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.svg#bell-fill') }}" />
            </svg>
            <span class="badge-number position-absolute translate-middle badge rounded-pill bg-danger"
                style="font-size: 0.7rem">
                {{ $countNotifications }}
            </span>
        </a>
        <ul class="dropdown-menu" style="max-height: 500px; overflow-y: scroll;"
            aria-labelledby="navbarDropdownMenuLink">
            @if ($countNotifications == 0)
                <li>
                    <a class="m-0 dropdown-item">No hay notificaciones</a>
                </li>
            @else
                <div class="d-flex justify-content-center">
                    <button onclick="markAllAsRead()" class="btn " style="color: red">
                        {{-- <a href="{{ route('message.markAllAsRead') }}" style="color: red"> --}}
                        <span style="margin-top: 20px">Marcar todas como leidas</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                        {{-- </a> --}}
                    </button>
                </div>
                @foreach ($unreadNotifications as $notification)
                    <li>
                        {{-- {{ dd($notificacion) }} --}}
                        <div class="dropdown-item m-0">
                            @if (array_key_exists('idTicket', $notification->data))
                                @permission('attend-ticket')
                                    <a href="{{ route('designer.show', ['ticket' => $notification->data['idTicket']]) }}"
                                        class="link-dark">
                                    @endpermission
                                    @permission('create-ticket')
                                        {{-- <a href="{{ route('tickets.show', ['ticket' => $notification->data['idTicket']]) }}"
                                            class="link-dark"> --}}
                                        @if (isset($notification->data['status']))
                                            @if ($notification->data['status'] == 'Falta de información')
                                                <a href="{{ route('tickets.edit', ['ticket' => $notification->data['idTicket']]) }}"
                                                    class="link-dark">
                                                @else
                                                    <a href="{{ route('tickets.show', ['ticket' => $notification->data['idTicket']]) }}"
                                                        class="link-dark">
                                            @endif
                                        @else
                                            <a href="{{ route('tickets.show', ['ticket' => $notification->data['idTicket']]) }}"
                                                class="link-dark">
                                        @endif
                                    @endpermission
                                @else
                                    <a href="#" class="link-dark">
                            @endif
                            <h6 class="mb-1">
                                {{ Str::limit($notification->data['ticket'], 28) }}</h6>
                            <p class="m-0">{{ $notification->data['emisor'] }}</p>

                            @switch($notification->type)
                                @case('App\Notifications\TicketCreateNotification')
                                    <p class="m-0">Se creo el ticket</p>
                                @break

                                @case('App\Notifications\ChangeStatusNotification')
                                    <p class="m-0">{{ $notification->data['status'] }}</p>
                                @break

                                @case('App\Notifications\StatusTicket')
                                    <p class="m-0">{{ $notification->data['status'] }}</p>
                                @break

                                @case('App\Notifications\MessageNotification')
                                    <p class="m-0">{{ Str::limit($notification->data['message'], 30) }}</p>
                                @break

                                @case('App\Notifications\TicketDeliveryNotification')
                                    <p class="m-0">Entrega Realizada</p>
                                @break

                                @case('App\Notifications\ChangePriorityNotification')
                                    <p class="m-0"><strong>Cambio de prioridad:</strong>
                                        {{ $notification->data['priority'] }}</p>
                                @break

                                @case('App\Notifications\TicketChangeNotification')
                                    <p class="m-0"><strong>Modificación del Ticket</strong></p>
                                @break

                                @case('App\Notifications\TicketDeliveryArts')
                                    <p class="m-0">Entrega de artes</p>
                                @break

                                @default
                            @endswitch
                            </a>

                            <p class="m-0 d-flex justify-content-between">
                                <a href="{{ route('message.markAsRead', ['notification' => $notification->id]) }}">Marcar
                                    como
                                    leido</a>
                            <div>
                                <p class="m-0">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            </p>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function markAllAsRead() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Marcarás todas las notificaciones como leídas",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Marcar como leídas'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('message.markAllAsRead') }}";
            }
        });
    }
</script>
