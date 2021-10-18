@extends('layouts.app')

@section('title')
    <h3>Editar usuario</h3>
@endsection

@section('content')

    <div class="card-header">
        <h4 class="card-title">Ingresa la información para modificar el usuario</h4>

    </div>
    <div class="card-body">

        <form action="{{ route('users.update', ['user' => $user->id]) }}" class="w-75" method="POST">
            <div class="row">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input class="form-control" type="text" name="name" required value="{{ $user->name }}">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <label for="lastname">Apellidos</label>
                    <input class="form-control" type="text" name="lastname" required value="{{ $user->lastname }}">
                    @error('lastname')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" required value="{{ $user->email }}">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
                <p>
                    <input type="submit" id="boton_crear" class="btn btn-success" value="Editar usuario">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                </p>
            </div>
        </form>
    </div>


@endsection
