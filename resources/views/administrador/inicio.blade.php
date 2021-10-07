<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio</title>
</head>

<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <h1>Bienvenido Administrador</h1>
        <h3>Inicio</h3>
        <h2>Samuel Administrador</h2>

        <ul>
            <li><a href="{{ route('inicio')}}">Inicio</a></li>
            <li><a href="{{ route('ver_usuario') }}">Ver usuario</a></li>
            <li><a href="{{ route('asignar_permisos') }}">Asignar permisos</a></li>
            <li><a href="#">Reporte de tickets</a></li>
            <li><a href="#">Cerrar Sesión</a></li>
        </ul>

        <br>

        <p> Total de tickets:<b>10</b><br /><br />
            Total de tickets abiertos:<b>3</b><br /><br />
            Total de tickets cerrados:<b>5</b><br /><br />
            Total de tickets pendientes:<b>2</b><br /><br />
        </p>

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
            </tr>

            <tr>
                <td>2</td>
                <td>Diseño especial Caribe Cooler</td>
                <td>Diseño especial</td>
                <td>En proceso</td>
            </tr>

            <tr>
                <td>3</td>
                <td>Virtual Barcel</td>
                <td>Virtual</td>
                <td>En revisión</td>
            </tr>

        </table>

    </div>
</body>

</html>
