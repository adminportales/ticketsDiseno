@extends('layouts.app')

@section('title')
    <h3>Lista de Equipos</h3>
@endsection

@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Información general de cada equipo</h4>
            <div class="btn-group" style="text-align:left">
                <a href="{{ route('teamsdiseno.create') }}" class="boton" aria-current="page">Crear</a>
            </div>
        </div>
    </div>


    <div class="card-body">

        <table class="table table-responsive" id="tableUsers">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Encargado</th>
                    <th>Equipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($teamsdiseno as $team)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $team->name }}</td>
                        <td>{{ $team->userDiseno->name . ' ' . $team->userDiseno->lastname }}</td>
                        <td>
                            @foreach ($team->membersDiseno as $user)
                                {{ $user->name . ' ' . $user->lastname }} <br>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="{{ route('teamsdiseno.edit', ['teamsdiseno' => $team->id]) }}"
                                class="btn btn-warning btn-sm mb-2">Editar</a>

                            <form action="{{ route('teamsdiseno.destroy', ['teamsdiseno' => $team->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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
