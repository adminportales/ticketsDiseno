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
                                class="btn size-btn btn-warning btn-sm mb-2">Editar</a>

                            <form action="{{ route('teamsdiseno.destroy', ['teamsdiseno' => $team->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn size-btn btn-danger btn-sm mb-2">Eliminar</button>
                            </form>
                            @if ($team->disabled == 0)
                                <button class="btn size-btn btn-outline-primary btn-sm"
                                    onclick="disableEquipo({{ $team->id }}, '{{ 1 }}')">Habilitar</button>
                            @else
                                <button class="btn size-btn btn-outline-danger btn-sm"
                                    onclick="disableEquipo({{ $team->id }}, '{{ 0 }}')">Deshabilitar</button>
                            @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableUsers").DataTable()
    </script>
    <script>
        function disableEquipo(teamIdc, disable) {
            Swal.fire({
                title: disable === 0 ? 'Deseas deshabilitar este equipo?' : 'Deseas habilitar este equipo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    changeDisabled(teamIdc, disable);
                }
            });
        }
        async function changeDisabled(teamId, disable) {
            try {
                let params = {
                    teamId: teamId,
                    disabled: disable,
                    _method: "post"
                };
                let res = await axios.post(
                    `teamsdiseno/disable`,
                    params
                );
                let data = res.data;
                if (data.message == 'OK') {
                    Swal.fire(
                        'Excelente!',
                        'Se cambio el estado correctamente',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                }
            } catch (error) {
                Swal.fire(
                    'Error!',
                    'No se pudo cambiar el estado',
                    'error'
                );
            }
        }
    </script>
@endsection
