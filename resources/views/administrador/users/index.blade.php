@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <div class="row">
            <div class="col-md-3 my-5">
                @include('administrador.menu')
            </div>
            <div class="col-md-9">

                <h1>Lista de usuarios</h1>
                <h3>Ver usuario</h3>

                <p>
                    Busca un usuario: <input type="search" name="buscar_usuario" size="15" maxlength="20">
                    <input type="submit" value="Buscar">
                </p>

                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de cración</th>
                        <th>Estatus</th>
                        <th>Modificar</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td>Activo</td>
                            <td><a href="{{ route('users.edit', ['user' => $user->id]) }}">Editar</a></td>
                            <td>
                                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>


                <a href="{{ route('users.create') }}">Crear nuevo usuario </a>
            </div>
        </div>

    @endsection
