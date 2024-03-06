@component('mail::message')
# ¡Buen día!
# {{ $emisor }} ha realizado un cambio de estado en el ticket: "{{ $ticket }}".
#
# Estado: {{ $status }}.


@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Ver ticket
@endcomponent
<hr>
Si tienes problemas para visualizar el botón, puedes hacer clic en el siguiente enlace: <a href="{{$url}}">{{$url}}</a>
@endcomponent
