@extends('layouts.app')

@section('content')

    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <div class="row">
            <div class="col-md-3 my-5">
                @include('administrador.menu')
            </div>
            <div class="col-md-9">

                <h1>Editar usuario</h1>

                <div class="d-flex justify-content-center">
                    <form action="{{ route('users.update', ['user' => $user->id]) }}" class="w-75" method="POST">
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
                            <input class="form-control" type="text" name="lastname" required
                                value="{{ $user->lastname }}">
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
                            <input type="submit" id="boton_crear" class="btn btn-warning" value="Editar usuario">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
        <script>
            const boton_crear = document.querySelector("#boton_crear");
            boton_crear.addEventListener('click', () => {
                confirm("¿Estas seguro de realizar cambios?")
            })
        </script>


    @endsection
