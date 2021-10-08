@component('mail::message')
# ¡Buen día, {{ $data['name'] }}!
# Bienvenido al sistema {{ config('app.name') }}
Has sido registrado como {{ $data['role'] }} con los siguientes datos:
<br>
Usuario: {{ $data['email'] }}
<br>
Password: {{ $data['password'] }}
@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Acceder
@endcomponent
Gracias,<br>
{{ config('app.name') }}
<hr>
Si tienes problemas para visualizar el boton, puedes hacer click en el siguiente enlace: <a href="{{$url}}">{{$url}}</a>
@endcomponent
