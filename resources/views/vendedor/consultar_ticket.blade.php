@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Consultar ticket</h1>
        <h3>Consultar ticket</h3>
        <h2>Tomas Vendedor</h2>
        <ul>
            <li><a href="{{ route('inicio_vendedor')}}"></a></li>
            <li><a href="{{ route('crear_ticket') }}">Crear tickets</a></li>
            <li><a href="{{ route('consultar_ticket') }}">Consultar Ticket</a></li>
<br>
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
                    <th><a href="{{ route('modificar_ticket') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticket') }}">Atender</a></th>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Presentacion de USB</td>
                    <td>Presentación</td>
                    <td>En proceso</td>
                    <th><a href="{{ route('modificar_ticket') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticket') }}">Atender</a></th>

                </tr>

                <tr>
                    <td>3</td>
                    <td>Diseño Bimbo</td>
                    <td>Diseño Especial</td>
                    <td>Ajustes</td>
                    <th><a href="{{ route('modificar_ticket') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticket') }}">Atender</a></th>

                </tr>

                <tr>
                    <td>4</td>
                    <td>Diseño Caribe Cooler</td>
                    <td>Virtual</td>
                    <td>En revisión</td>
                    <th><a href="{{ route('modificar_ticket') }}">Modificar</a></th>
                    <th><a href="{{ route('atender_ticket') }}">Atender</a></th>

                </tr>

            </table>
@endsection
