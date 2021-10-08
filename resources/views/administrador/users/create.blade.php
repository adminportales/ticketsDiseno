@extends('layouts.app')

@section('content')

    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <div class="row">
            <div class="col-md-3 my-5">
                @include('administrador.menu')
            </div>
            <div class="col-md-9">
                <h1>Crear nuevo usuario</h1>

                <div class="d-flex justify-content-center">
                    <form action="{{ route('users.store') }}" class="w-75" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input class="form-control" type="text" name="name" required>
                            @error('name')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lastname">Apellidos</label>
                            <input class="form-control" type="text" name="lastname" required>
                            @error('lastname')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" required>
                            @error('email')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Seleccione el rol del usuario</label>
                            <select name="role" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    <br>
                                @endforeach
                            </select>
                            @error('role')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="form-group">

                        </div>
                        <p>
                            <input type="submit" id="boton_crear" class="btn btn-success" value="Crear nuevo usuario">
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
