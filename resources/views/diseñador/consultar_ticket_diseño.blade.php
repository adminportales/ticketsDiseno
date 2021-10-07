<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultar ticket</title>
</head>
<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Bienvenido Federico</h1>
        <h3>Inicio</h3>
        <h2>Federico Diseñador</h2>
        <ul>
            <li><a href="{{ route('inicio_diseno') }}">Inicio</a></li>
            <li><a href="{{ route('consultar_ticket_diseño') }}">Consultar Ticket</a></li>

        </ul>

        <table>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Categoria de Ticket</th>
                <th>Estatus</th>

            </tr>

            <tr>
                <td>1</td>
                <td>Presentacion Bimbo</td>
                <td>Presentación</td>
                <td>Nuevo</td>
                <th><a href="{{ route('atender_ticket_diseño') }}">Atender ticket</a></th>
            </tr>

            <tr>
                <td>2</td>
                <td>Diseño especial Caribe Cooler</td>
                <td>Diseño especial</td>
                <td>En proceso</td>
                <th><a href="{{ route('atender_ticket_diseño') }}">Atender ticket</a></th>
            </tr>

            <tr>
                <td>3</td>
                <td>Virtual Barcel</td>
                <td>Virtual</td>
                <td>En revisión</td>
                <th><a href="{{ route('atender_ticket_diseño') }}">Atender ticket</a></th>
            </tr>

        </table>
</body>
</html>
