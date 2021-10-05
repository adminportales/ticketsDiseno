<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asignar permisos</title>
</head>
<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <h1>Permisos</h1>
            <h3>Asignar permisos</h3>
            <h2>Samuel Administrador</h2>
            <ul>
            <li><a href="{{route('ver_usuario')}}">Ver usuario</a></li>
            <li><a href="{{ route('asignar_permisos') }}">Asignar permisos</a></li>
            <li><a href="#">Reporte de tickets</a></li>
            <li><a href="#">Cerrar Sesión</a></li>
            </ul>

            <p>
                Busca un usuario: <input type="search" name="buscar_usuario" size="15" maxlength="20">
                <input type="submit" value="Buscar">
            </p>

            <table>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Rol</th>
                  <th># Permisos</th>
                </tr>

                <tr>
                  <td>1</td>
                  <td>Samuel</td>
                  <td>Vendedor</td>
                  <td>2</td>
                  <td><a href="{{route('editar_usuario')}}">Editar</a></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Tomas</td>
                    <td>Diseñador</td>
                    <td>2</td>
                    <td><a href="{{route('editar_usuario')}}">Editar</a></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Federico</td>
                    <td>Gerente de ventas</td>
                    <td>3</td>
                    <td><a href="{{route('editar_usuario')}}">Editar</a></td>
                </tr>

               </table>


</body>
</html>
