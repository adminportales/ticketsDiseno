@extends('layouts.app')

@section('title')
    <h3>Lista de Usuarios</h3>
@endsection

@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Información general de cada usuario</h4>
            <div class="btn-group" style="text-align:left">
                <a href="{{ route('users.create') }}" class="boton" aria-current="page">Crear</a>
                <a href="{{ Request::root() . '/roles_assignment' }}" class="boton">Asignar permisos</a>
                <a href="{{ route('user.import') }}" class="boton">Importar</a>
            </div>
        </div>

    </div>


    <div class="card-body">

        <table class="table table-responsive" id="tableUsers">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Registro</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>

                            @foreach ($user->whatRoles as $role)
                                {{ $loop->iteration . '. ' . $role->display_name }}
                            @endforeach

                        </td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>
                            <span class="badge bg-{{ $user->status ? 'light-success' : 'light-danger' }}">
                                {{ $user->status ? 'Activo' : 'Inactivo' }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Desactivar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <style>
        table.dataTable td {
            padding: 15px 8px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableUsers").DataTable()
    </script>
@endsection
