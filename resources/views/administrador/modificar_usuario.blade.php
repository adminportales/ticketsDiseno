<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modificar usuario</title>
</head>

<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <h1>Modificar usuario</h1>
        <h3>Ver usuario</h3>
        <h2>Samuel Administrador</h2>
        <ul>
            <li><a href="{{ route('inicio')}}">Inicio</li>
            <li><a href="{{ route('ver_usuario') }}">Ver usuario</a></li>
            <li><a href="{{ route('asignar_permisos') }}">Asignar permisos</a></li>
            <li><a href="{{ route('reporte_tickets') }}">Reporte de tickets</a></li>
            <li><a href="#">Cerrar Sesión</a></li>
        </ul>

        <form action="">
            <p>Nombre a modificar: <input type="text" name="nombre" size="40" required></p>
            <p>Apellidos a modificar: <input type="text" name="apellidos" size="40" required></p>
            <p>Email a modificar: <input type="email" name="email" size="40" required></p>
            <p>Contraseña: <input type="password" size="40" required></p>
            <p>Estatus: <select name="Estatus">
                    <option>Activo</option>
                    <option>Inactivo</option>
                </select>

                <input type="button" id="btn_modificar" value="Hacer cambios">
                <input type="reset" value="Cancelar">
            </p>

        </form>
        <script>
            const boton_alerta = document.querySelector("#btn_modificar");
            boton_alerta.addEventListener('click', () => {
                confirm("¿Estas seguro de realizar cambios?")
            })
        </script>
</body>

</html>
