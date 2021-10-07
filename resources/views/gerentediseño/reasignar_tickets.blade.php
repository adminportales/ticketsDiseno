@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Bienvenido Ernesto</h1>
        <h3>Inicio</h3>
        <h2>Ernesto Gerente de diseño</h2>
        <ul>
            <li><a href="{{ route('inicio_gerente_diseño') }}">Inicio</a></li>
            <li><a href="{{ route('consultar_ticketgerente') }}">Consultar ticket</a></li>
            <li><a href="{{ route('reasignar_tickets') }}">Reasignar tickets</a></li>
        </ul>
        <br>

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
                <th> <select name="usuarios">
                        <option>Diseñador1
                        </option>
                        <option>Diseñador2
                        </option>
                        <option>Diseñador3
                        </option>
                </th>
            </tr>

            <tr>
                <td>2</td>
                <td>Diseño especial Caribe Cooler</td>
                <td>Diseño especial</td>
                <td>En proceso</td>
                <th> <select name="usuarios">
                        <option>Diseñador1
                        </option>
                        <option>Diseñador2
                        </option>
                        <option>Diseñador3
                        </option>
                </th>

            </tr>

            <tr>
                <td>3</td>
                <td>Virtual Barcel</td>
                <td>Virtual</td>
                <td>En revisión</td>
                <th> <select name="usuarios">
                        <option>Diseñador1
                        </option>
                        <option>Diseñador2
                        </option>
                        <option>Diseñador3
                        </option>
                </th>
            </tr>

        </table>
        <br>
        <input type="submit" value="Guardar">
@endsection
