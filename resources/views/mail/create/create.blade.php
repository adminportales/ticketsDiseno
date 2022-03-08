@component('mail::message')
# ¡Buen día!
# {{ $emisor }} ha creado el siguiente ticket: "{{ $ticket }}".


@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Ver ticket
@endcomponent
<hr>
Si tienes problemas para visualizar el boton, puedes hacer click en el siguiente enlace: <a href="{{$url}}">{{$url}}</a>
@endcomponent
