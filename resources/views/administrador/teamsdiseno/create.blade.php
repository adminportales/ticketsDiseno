@extends('layouts.app')

@section('title')
    <h3>Lista de Equipos</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Ingresa la información para crear un nuevo equipo para el diseñador</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('teamsdiseno.store') }}" method="POST" autocomplete="off">
            <div class="row">
                @csrf
                @method('POST')
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre del equipo</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Diseñador</label>
                        <select name="user" class="form-select" id="userEncargado">
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name . ' ' . $item->lastname }}
                                </option>
                            @endforeach
                        </select>
                        @error('user')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="members">Participantes (Vendedores)</label>
                        <select name="team[]" class="form-select" multiple data-placeholder="Selecciona Usuario"
                            id="select2" data-coreui-search="true">
                            @foreach ($list_users_ventas as $user)
                                <option value="{{ $user->id }}">{{ $user->name . '' . $user->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end ">
                    <a href="{{ route('teamsdiseno.index') }}" class="btn btn-danger"
                        style="margin-right: 10px">Cancelar</a>
                    <input type="submit" id="boton_crear" class="boton" value="Crear nuevo equipo">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <style>
        table.dataTable td {
            padding: 15px 8px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
        }

        .mt-100 {
            margin-top: 100px
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select2').select2();
    });
</script>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#userEncargado').select2();
        });
    </script>
@endsection
