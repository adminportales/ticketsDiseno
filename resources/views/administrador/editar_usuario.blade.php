<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar usuario</title>
</head>

<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <h1>Editar usuario</h1>
        <h3>Asignar permisos</h3>
        <h2>Samuel Administrador</h2>
        <ul>
            <li><a href="{{ route('inicio')}}">Inicio</a></li>
            <li><a href="{{ route('ver_usuario') }}">Ver usuario</a></li>
            <li><a href="{{ route('asignar_permisos') }}">Asignar permisos</a></li>
            <li><a href="{{ route('reporte_tickets') }}">Reporte de tickets</a></li>
            <li><a href="#">Cerrar Sesión</a></li>
        </ul>

        <form action="">
            <p>Nombre: <input type="text" name="nombre" size="40" required></p>

            <p>

                <b> Roles</b><br>

                <input type="radio" name="boton" value="1"> Administrador<br>
                <input type="radio" name="boton" value="2"> Diseñador<br>
                <input type="radio" name="boton" value="3"> Vendedor<br>
                <input type="radio" name="boton" value="4"> Gerente de ventas<br>
                <input type="radio" name="boton" value="5"> Gerente de diseño<br>
                <br>

                <b> Permisos</b><br>

                <input type="checkbox" name="permiso" value="1">Lectura
                <br>
                <input type="checkbox" name="permiso" value="2">Escritura
                <br>
                <input type="checkbox" name="permiso" value="3">Ejecución
                <br>
                <input type="checkbox" name="permiso" value="4">Creación
                <br>
                <input type="checkbox" name="permiso" value="5">Borrado



            </p>

        </form>


</body>

</html>
