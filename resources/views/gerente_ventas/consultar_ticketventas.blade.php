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
        <h1>Consultar ticket</h1>
        <h3>Consultar ticket</h3>
        <h2>Aide Gerente de Ventas</h2>
        <ul>
            <li><a href="{{ route('inicio_gerenteventas') }}">Inicio</a></li>
            <li><a href="{{ route('crear_ticketventas') }}">Crear ticket</a></li>
            <li><a href="{{ route('consultar_ticketventas') }}">Consultar ticket</a></li>
            <li><a href="{{ route('asignar_prioridades') }}">Asignar prioridades</a></li>
            <br>
            Busca un ticket: <input type="search" name="buscar_ticket" size="15" maxlength="20">
            <input type="submit" value="Buscar">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Categoria</th>
                    <th>Estatus</th>


                </tr>

                <tr>
                    <td>1</td>
                    <td>Virtual Adidas</td>
                    <td>Virtual</td>
                    <td>Nuevo</td>
                    <th><a href="{{ route('modificar_ticketventas') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticketventas') }}">Atender</a></th>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Presentacion de USB</td>
                    <td>Presentación</td>
                    <td>En proceso</td>
                    <th><a href="{{ route('modificar_ticketventas') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticketventas') }}">Atender</a></th>

                </tr>

                <tr>
                    <td>3</td>
                    <td>Diseño Bimbo</td>
                    <td>Diseño Especial</td>
                    <td>Ajustes</td>
                    <th><a href="{{ route('modificar_ticketventas') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticketventas') }}">Atender</a></th>

                </tr>

                <tr>
                    <td>4</td>
                    <td>Diseño Caribe Cooler</td>
                    <td>Virtual</td>
                    <td>En revisión</td>
                    <th><a href="{{ route('modificar_ticketventas') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticketventas') }}">Atender</a></th>

                </tr>

            </table>
</body>

</html>
