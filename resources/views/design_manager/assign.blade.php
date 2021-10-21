@extends('layouts.app')

@section('title')
    <h3>Tickets asignados</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general de tickets asignados</h4>
    </div>
    <div class="card-body">
        <table class="table" id="tableTickets">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Diseñador</th>
                    <th>Categoria de Ticket</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>

                        <td>
                            @foreach ($user->whatTypes as $type)
                                {{ $type->type }}
                            @endforeach
                        </td>

                        <td><a href="{{ route('design_manager.edit', ['user' => $user->id]) }}"
                                class="btn btn-primary">Editar asignación</a></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}"> --}}
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
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script> --}}
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
