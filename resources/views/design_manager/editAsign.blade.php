@extends('layouts.app')

@section('title')
    <h3>Editar asignaciones</h3>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Nombre</h4>

        </div>

        <div class="card.-header">
            <h4 class="card-title">Categoria de ticket</h4>
        </div>

        <div class="card-body">
            @foreach ($types as $type)

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1"
                        value="{{ $type->id }}">
                    <label class="form-check-label" for="flexRadioDefault1">
                        {{ $type->type }}
                    </label>
                </div>
            @endforeach
            <br>

            <input type="submit" value="Guardar cambios" class="btn btn-success">
        </div>
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
