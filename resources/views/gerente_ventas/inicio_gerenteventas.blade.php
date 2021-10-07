@extends('layouts.app')

@section('content')
<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Bienvenido Aide</h1>
        <h3>Inicio</h3>
        <h2>Aide Gerente de ventas</h2>
        <ul>
            <li><a href="{{ route('inicio_gerenteventas') }}">Inicio</a></li>
            <li><a href="{{ route('crear_ticketventas') }}">Crear ticket</a></li>
            <li><a href="{{ route('consultar_ticketventas') }}">Consultar ticket</a></li>
            <li><a href="{{ route('asignar_prioridades') }}">Asignar prioridades</a></li>
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
@endsection
