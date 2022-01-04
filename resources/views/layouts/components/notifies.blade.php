@if (count(auth()->user()->notifications) == 0)
    <li>
        <a class="m-0 dropdown-item">No hay notificaciones</a>
    </li>
@else
    @foreach (auth()->user()->unreadNotifications as $notification)
        <li>
            {{-- {{ dd($notificacion) }} --}}
            <div class="dropdown-item m-0">
                @if (array_key_exists('idTicket', $notification->data))
                    @permission('attend-ticket')
                        <a href="{{ route('designer.show', ['ticket'=>$notification->data['idTicket']]) }}" class="link-dark">
                    @endpermission
                    @permission('create-ticket')
                        <a href="{{ route('tickets.show', ['ticket'=>$notification->data['idTicket']]) }}" class="link-dark">
                    @endpermission
                @else
                    <a href="#" class="link-dark">
                @endif
                    <h6 class="mb-1">{{ Str::limit($notification->data['ticket'], 28) }}</h6>
                    <p class="m-0">{{ $notification->data['emisor'] }}</p>
                    @switch($notification->type)
                        @case('App\Notifications\TicketCreateNotification')
                            <p class="m-0">Se creo el ticket</p>
                        @break
                        @case('App\Notifications\ChangeStatusNotification')
                            <p class="m-0">{{ $notification->data['status'] }}</p>
                        @break
                        @case('App\Notifications\MessageNotification')
                            <p class="m-0">{{ Str::limit($notification->data['message'], 30) }}</p>
                        @break
                        @case('App\Notifications\ChangePriorityNotification')
                            <p class="m-0"><strong>Cambio de prioridad:</strong>
                                {{ $notification->data['priority'] }}</p>
                        @break
                        @default
                    @endswitch
                </a>
                <p class="m-0"><a
                        href="{{ route('message.markAsRead', ['notification' => $notification->id]) }}">Marcar
                        como
                        leido</a></p>
            </div>

        </li>
    @endforeach
@endif
