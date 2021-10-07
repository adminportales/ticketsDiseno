@extends('layouts.app')

@section('content')

<body>
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <h1>Tickets</h1>
        <h3>Reporte de tickets</h3>
        <h2>Samuel Administrador</h2>
        <ul>
            <li><a href="{{ route('inicio')}}">Inicio</a></li>
            <li><a href="{{ route('ver_usuario') }}">Ver usuario</a></li>
            <li><a href="{{ route('asignar_permisos') }}">Asignar permisos</a></li>
            <li><a href="{{ route('reporte_tickets') }}">Reporte de tickets</a></li>
            <li><a href="#">Cerrar Sesión</a></li>
        </ul>

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

            </tr>

            <tr>
                <td>2</td>
                <td>Presentacion de USB</td>
                <td>Presentación</td>
                <td>En proceso</td>

            </tr>

            <tr>
                <td>3</td>
                <td>Diseño Bimbo</td>
                <td>Diseño Especial</td>
                <td>Ajustes</td>

            </tr>

            <tr>
                <td>4</td>
                <td>Diseño Caribe Cooler</td>
                <td>Virtual</td>
                <td>En revisión</td>

            </tr>

        </table>
@endsection
