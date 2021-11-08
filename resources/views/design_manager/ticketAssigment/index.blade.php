@extends('layouts.app')

@section('title')
    <h3>Tickets por defecto</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Tickets por defecto para cada diseñador</h4>
    </div>
    <div class="card-body">
        <table class="table" id="tableTeam">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Diseñador</th>
                    <th>Tipos de Tickets</th>
                    <th>Disponibilidad</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ auth()->user()->name }}</td>

                    <td>
                        @foreach (auth()->user()->whatTypes as $type)
                            {{ $type->type }}
                        @endforeach
                    </td>
                    <td>
                        <change-status-designer :availability={{ auth()->user()->profile->availability }}
                            :user={{ auth()->user()->id }}>
                        </change-status-designer>
                    </td>
                    <td><a href="{{ route('ticketAssigment.edit', ['user' => auth()->user()->id]) }}"
                            class="boton">Editar
                            asignación</a></td>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + 1 }}</td>
                        <td>{{ $user->name }}</td>

                        <td>
                            @foreach ($user->whatTypes as $type)
                                {{ $type->type }}
                            @endforeach
                        </td>
                        <td>
                            <change-status-designer :availability={{ $user->profile->availability }}
                                :user={{ $user->id }}>
                            </change-status-designer>
                        </td>

                        <td><a href="{{ route('ticketAssigment.edit', ['user' => $user->id]) }}"
                                class="boton">Editar asignación</a></td>

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
        let jquery_datatable = $("#tableTeam").DataTable()
    </script>
@endsection
