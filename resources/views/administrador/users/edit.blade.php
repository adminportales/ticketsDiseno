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
                <div class="col-md-6">
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
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" required value="{{ $user->email }}">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="company">La empresa a la que pertenece</label>
                        <select name="company" class="form-control">
                            <option value="">Seleccione</option>
                            @php
                                $companies = ['BH TradeMarket', 'Promo Life','Promo Zale', 'Unipromtex'];
                            @endphp
                            @foreach ($companies as $company)
                                <option {{ $company == $user->profile->company ? 'selected' : '' }}
                                    value="{{ $company }}">
                                    {{ $company }}</option>
                                <br>
                            @endforeach
                        </select>

                        @error('company')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <p>
                    <input type="submit" id="boton_crear" class="boton" value="Editar usuario"> <br>
                    <a href="{{ route('users.index') }}" class="btn btn-danger">Cancelar</a>
                </p>
            </div>
        </form>
    </div>

@endsection
