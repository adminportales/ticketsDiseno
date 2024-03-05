@component('mail::message')

<div style="text-align:left; font-size: 20px; font-weight: bold; color: black;">
    ¡Buen día, {{$receptor}}!
</div>
<br>
<div style="text-align: justify; font-family: 'Roboto', sans-serif;">
{{$emisor}} ha agregado un mensaje en ticket que lleva por título "{{$title_ticket}}"
<br>
<div style="font-family: 'Roboto', sans-serif; color: black; font-weight: bold;">
    El mensaje que envio es "{{$message}}"
</div>
<br>
Saludos cordiales,Equipo de Diseño.
<br>
</div>
<br>
@endcomponent
