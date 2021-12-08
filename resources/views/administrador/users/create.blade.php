@extends('layouts.app')

@section('title')
    <h3>Crear Usuario</h3>
@endsection

@section('content')

    <div class="card-header">
        <h4 class="card-title">Ingresa la información para crear un nuevo usuario</h4>
    </div>
    <div class="card-body">

        <form action="{{ route('users.store') }}" method="POST">
            <div class="row">
                @csrf
                @method('POST')
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">Apellidos</label>
                        <input class="form-control" type="text" name="lastname" value="{{ old('lastname') }}">
                        @error('lastname')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="company">La empresa a la que pertenece</label>
                        <select name="company" class="form-control">
                            <option value="">Seleccione</option>
                            @php
                                $companies = ['BH', 'Promo Life','Promo Zale', 'TradeMarket', 'Unipromtex'];
                            @endphp
                            @foreach ($companies as $company)
                                <option {{ $company == old('company') ? 'selected' : '' }} value="{{ $company }}">
                                    {{ $company }}</option>
                                <br>
                            @endforeach
                        </select>

                        @error('company')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Seleccione el rol del usuario</label>
                        <select name="role" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($roles as $role)

                                <option {{ $role->id == old('role') ? 'selected' : '' }} value="{{ $role->id }}">
                                    {{ $role->display_name }}</option>
                                <br>
                            @endforeach
                        </select>

                        @error('role')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <p>
                    <input type="submit" id="boton_crear" class="boton" value="Crear nuevo usuario"><br>
                    <a href="{{ route('users.index') }}" class="btn btn-danger">Cancelar</a>
                </p>
            </div>
        </form>
    </div>
@endsection
