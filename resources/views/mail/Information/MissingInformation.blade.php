@component('mail::message')

<div style="text-align:left; font-size: 20px; font-weight: bold; color: black;">
    ¡Buen día, {{$receptor}}!
</div>
<br>
<div style="text-align: justify; font-family: 'Roboto', sans-serif;">
Quisiera informarte sobre una observación importante relacionada con el ticket que has creado bajo el título 
" {{$ticket}} ". 
{{$emisor}} ha señalado que falta información crucial en este ticket.
Es esencial asegurarnos de que la solicitud esté completa para poder avanzar con el diseño. 
Por favor, se solicita que regreses y edites el ticket, asegurándote de no omitir ningún detalle en los campos requeridos.
Agradezco tu pronta atención y colaboración en este asunto. 

{{$emisor}} igual agrego un comentario "{{$message}}"

@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Ver ticket
@endcomponent

Saludos cordiales,Equipo de Diseño.
</div>

<hr>
Si tienes problemas para visualizar el botón, puedes hacer clic en el siguiente enlace: <a href="{{$url}}">{{$url}}</a>
@endcomponent


