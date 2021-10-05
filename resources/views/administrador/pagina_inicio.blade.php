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
    <li><a href="{{route('ver_usuario')}}">Ver usuario</a></li>
    <li><a href="{{ route('asignar_permisos') }}">Asignar permisos</a></li>
    <li><a href="#">Reporte de tickets</a></li>
    <li><a href="#">Cerrar Sesión</a></li>
    </ul>

    <table >
  <tr>
    <th>Seleccionar</th>
    <th>Categoria de Ticket</th>
    <th>Estatus</th>

  </tr>

  <tr>
    <td><input type="checkbox"></td>
    <td>Virtual</td>
    <td>Nuevo</td>

  </tr>

  <tr>
    <td><input type="checkbox"></td>
    <td>Presentaciones</td>
    <td>En proceso</td>

  </tr>

  <tr>
    <td><input type="checkbox"></td>
    <td>Diseños especiales</td>
    <td>Finalizado</td>

  </tr>

 </table>

</div>
</body>
</html>
