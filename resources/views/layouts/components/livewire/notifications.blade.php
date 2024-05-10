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
                                        <a href="{{ route('tickets.show', ['ticket' => $notification->data['idTicket']]) }}"
                                            class="link-dark">
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
                                    <p class="m-0"><strong>Modificacion del Ticket</strong></p>
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
