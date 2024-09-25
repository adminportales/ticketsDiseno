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
                <div class="px-2">
                    <a href="{{ Request::root() . '/roles_assignment' }}" class="boton">Asignar permisos</a>
                </div>
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
                    {{-- <th>Registro</th> --}}
                    {{-- <th>Estatus</th> --}}
                    <th>Ultimo Ingreso</th>
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
                                <br>
                            @endforeach

                        </td>
                        {{-- <td>{{ $user->created_at->diffForHumans() }}</td> --}}
                        <td>
                            @if ($user->last_login)
                                {{ $user->last_login }}
                            @else
                                <p>No hay registro</p>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="mb-2">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                    class="btn btn-warning btn-sm size-btn">Editar</a>
                            </div>
                            <div class="mb-2">
                                <a href="{{ url('roles_assignment/roles-assignment/' . $user->id . '/edit?model=users') }}"
                                    class="btn btn-primary btn-sm size-btn">Permisos</a>
                            </div>
                            <div>
                                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-outline-danger btn-sm size-btn">Desactivar</button>
                                </form>
                            </div>
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
