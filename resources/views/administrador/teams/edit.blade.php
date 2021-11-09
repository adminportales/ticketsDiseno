@extends('layouts.app')

@section('title')
    <h3>Editar Equipo</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Edita la información de este equipo</h4>
    </div>
    <div class="card-body">

        <form action="{{ route('teams.update', ['team' => $team->id]) }}" method="POST" autocomplete="off">
            <div class="row">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre del equipo</label>
                        <input class="form-control" type="text" name="name" value="{{ $team->name }}">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Encargado</label>
                        <select name="user" class="form-control" id="userEncargado">
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}" {{ $team->user_id == $item->id ? 'selected' : '' }}>
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
                        <members-team members='{{ $membersId }}'></members-team>
                        @error('team')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <p>
                    <input type="submit" id="boton_crear" class="boton" value="Crear nuevo usuario">
                    <a href="{{ route('users.index') }}" class="btn btn-danger">Cancelar</a>
                </p>
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#userEncargado').select2();
        });
    </script>
@endsection
