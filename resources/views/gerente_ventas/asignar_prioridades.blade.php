<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asignar prioridades</title>
</head>
<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Asignar prioridades</h1>
        <h3>Asignar prioridades</h3>
        <h2>Aide Gerente de ventas</h2>
        <ul>
            <li><a href="{{ route('inicio_gerenteventas') }}">Inicio</a></li>
            <li><a href="{{ route('crear_ticketventas') }}">Crear ticket</a></li>
            <li><a href="{{ route('consultar_ticketventas') }}">Consultar ticket</a></li>
            <li><a href="{{ route('asignar_prioridades') }}">Asignar prioridades</a></li>
        </ul>

        <br>
        <table>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Categoria</th>
                <th>Prioridad</th>


            </tr>

            <tr>
                <td>1</td>
                <td>Virtual Adidas</td>
                <td>Virtual</td>
                <td><select name="prioridad1">
                    <option>Alta
                    </option>
                    <option>Media
                    </option>
                    <option>Baja
                    </option>
                </select></td>
            </tr>

            <tr>
                <td>2</td>
                <td>Presentacion de USB</td>
                <td>Presentación</td>
                <td> <select name="prioridad2">
                    <option>Alta
                    </option>
                    <option>Media
                    </option>
                    <option>Baja
                    </option>
                </select></td>

            </tr>

            <tr>
                <td>3</td>
                <td>Diseño Bimbo</td>
                <td>Diseño Especial</td>
                <td> <select name="prioridad3">
                    <option>Alta
                    </option>
                    <option>Media
                    </option>
                    <option>Baja
                    </option>
                </select></td></td>

            </tr>

            <tr>
                <td>4</td>
                <td>Diseño Caribe Cooler</td>
                <td>Virtual</td>
                <td><select name="prioridad4">
                    <option>Alta
                    </option>
                    <option>Media
                    </option>
                    <option>Baja
                    </option>
                </select></td></td>

            </tr>

        </table>
        <br>
        <input type="submit" value="Guardar">
</body>
</html>
