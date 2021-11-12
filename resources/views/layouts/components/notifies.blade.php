@if (count(auth()->user()->notifications) == 0)
    <h6 class="mb-1">No hay notificaciones</h6>
@endif
@foreach (auth()->user()->unreadNotifications as $notification)
    <div class="border rounded p-1 my-1 d-flex">
        <div class="w-75">
            <h6 class="mb-1">{{ $notification->data['ticket'] }}</h6>
            <p class="m-0">{{ $notification->data['emisor'] }}</p>
            @switch($notification->type)
                @case('App\Notifications\TicketCreateNotification')
                    <p class="m-0">Se creo el ticket</p>
                @break
                @case('App\Notifications\ChangeStatusNotification')
                    <p class="m-0">{{ $notification->data['status'] }}</p>
                @break
                @case('App\Notifications\MessageNotification')
                    <p class="m-0">{{ $notification->data['message'] }}</p>
                @break
                @default
            @endswitch
        </div>
        <div class="d-flex justify-content-around flex-column">
            <a href="">Leido</a>
            <a href="">Ver</a>
        </div>
    </div>
@endforeach
