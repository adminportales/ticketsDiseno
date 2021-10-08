@extends('layouts.app')

@section('content')

    <body>
        <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
            <h1>Lista de usuarios</h1>
            <h3>Ver usuario</h3>
            <h2>Samuel Administrador</h2>
            @include('administrador.menu')

            <p>
                Busca un usuario: <input type="search" name="buscar_usuario" size="15" maxlength="20">
                <input type="submit" value="Buscar">
            </p>


            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de cración</th>
                    <th>Estatus</th>
                    <th>Modificar</th>
                </tr>

                <tr>
                    <td>1</td>
                    <td>Samuel</td>
                    <td>edwin_samuel@hotmail.com</td>
                    <td>10:00am</td>
                    <td>Activo</td>
                    <td><a href="{{ route('modificar_usuario') }}">Editar</a></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Tomas</td>
                    <td>tomas@hotmail.com</td>
                    <td>02:00pm</td>
                    <td>Activo</td>
                    <td><a href="#">Editar</a></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Federico</td>
                    <td>fede@hotmail.com</td>
                    <td>10:40am</td>
                    <td>Inactivo</td>
                    <td><a href="#">Editar</a></td>
                </tr>

            </table>


            <a href="{{ route('users.create') }}">Crear nuevo usuario </a>

        @endsection
