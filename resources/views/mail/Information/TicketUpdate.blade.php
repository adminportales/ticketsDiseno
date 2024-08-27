@component('mail::message')
<div style="text-align:left; font-size: 20px; font-weight: bold; color: black;">
¡Buen día, {{ $receptor }}!
</div>
<br>
<div style="text-align: justify; font-family: 'Roboto', sans-serif;">

{{ $emisor }} ha modificado el ticket que lleva por título "{{ $ticket }}".

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Ver ticket
@endcomponent

</div>

<hr>
Si tienes problemas para visualizar el botón, puedes hacer clic en el siguiente enlace: <a
href="{{ $url }}">{{ $url }}</a>
@endcomponent
