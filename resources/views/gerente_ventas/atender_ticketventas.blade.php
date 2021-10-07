<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Atender ticket</title>
</head>
<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Atender ticket</h1>
        <h3>Consultar ticket</h3>
        <h2>Aide Gerente de Ventas</h2>
        <ul>
            <li><a href="{{ route('inicio_gerenteventas') }}">Inicio</a></li>
            <li><a href="{{ route('crear_ticketventas') }}">Crear ticket</a></li>
            <li><a href="{{ route('consultar_ticketventas') }}">Consultar ticket</a></li>
            <li><a href="{{ route('asignar_prioridades') }}">Asignar prioridades</a></li>
        </ul>

</body>
</html>
