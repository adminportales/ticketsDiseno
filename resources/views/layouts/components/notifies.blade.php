@if (count(auth()->user()->notifications) == 0)
    <h6 class="mb-1">No hay notificaciones</h6>
@endif
@foreach (auth()->user()->unreadNotifications as $notification)
    <div class="border rounded p-1 my-1">
        <h6 class="mb-1">{{ $notification->data['ticket'] }}</h6>
        <p class="m-0">{{ $notification->data['emisor'] }}</p>
        @switch($notification->type)
            @case('App\Notifications\TicketCreateNotification')
                <p class="m-0">Se creo el ticket</p>
            @break
            @case(2)

            @break
            @default

        @endswitch
        <div class="d-flex justify-content-around">
            <a href="">Marcar como leido</a>
            <a href="">Ver</a>
        </div>
    </div>
@endforeach
