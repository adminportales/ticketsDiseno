@component('mail::message')
# ¡Buen día!
# Tu solicitud ha sido resuelta "{{ $ticket }}"
{{ $emisor }} ha entregado los archivos de tu solicitud.


@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Ver ticket
@endcomponent
<hr>
Si tienes problemas para visualizar el boton, puedes hacer click en el siguiente enlace: <a href="{{$url}}">{{$url}}</a>
@endcomponent
