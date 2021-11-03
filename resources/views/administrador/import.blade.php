@extends('layouts.app')

@section('title')
    <h3> {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
@endsection

@section('content')

    <div class="card-header">
        <h4 class="card-title">Lista de Usuarios</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data">
            @csrf

            <p>
                Sube un archivo:

                <input type="file" class="boton" name="excel">
                <br><br>
                <input type="submit" class="boton" value="Enviar datos">

            </p>
        </form>
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
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableUsers").DataTable()
    </script>
@endsection
