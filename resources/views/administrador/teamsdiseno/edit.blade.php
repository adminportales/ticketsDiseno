@extends('layouts.app')
@section('title')
    <h3>Editar Equipo</h3>
@endsection
@section('content')
    <div class="card-header">
        <h4 class="card-title">Edita la información de este equipo</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('teamsdiseno.update', ['teamsdiseno' => $teamsdiseno->id]) }}" method="POST"
            autocomplete="off">
            <div class="row">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre del equipo</label>
                        <input class="form-control" type="text" name="name" value="{{ $teamsdiseno->name }}">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Diseñador</label>
                        <select name="user" class="form-control" id="userEncargado">
                            @foreach ($users_diseño as $item)
                                <option value="{{ $item->id }}"
                                    {{ $teamsdiseno->user_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name . ' ' . $item->lastname }}
                            @endforeach
                        </select>
                        @error('user')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="members">Participantes del equipo</label>
                        <select name="team[]" class="form-select" multiple data-placeholder="Selecciona Usuario"
                            id="select2" data-coreui-search="true">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if (in_array($user->id, explode(',', $membersId))) selected @endif>
                                    {{ $user->name . ' ' . $user->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end ">
                    <a href="{{ route('teamsdiseno.index') }}" class="btn btn-danger"
                        style="margin-right: 10px">Cancelar</a>
                    <input type="submit" id="boton_crear" class="boton" value="Crear nuevo usuario">
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
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <style>
        table.dataTable td {
            padding: 15px 8px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
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
