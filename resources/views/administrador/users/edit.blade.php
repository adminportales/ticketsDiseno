@extends('layouts.app')

@section('title')
    <h3>Editar usuario</h3>
@endsection

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="card-title">Ingresa la información para modificar el usuario</h4>
                <br>
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input class="form-control" type="text" name="name" required
                                    value="{{ $user->name }}">
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" required
                                    value="{{ $user->email }}">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="company">La empresa a la que pertenece</label>
                                <select name="company" class="form-control">
                                    <option value="">Seleccione</option>
                                    @php
                                        $companies = ['BH TradeMarket', 'Promo Life', 'Promo Zale', 'Unipromtex'];
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
            <div class="col-md-4">
                @if ($user->hasRole('sales_assistant') || $user->hasRole('seller'))
                    <h4 class="card-title">Gerente</h4>
                    @if ($user->teamMember->where('role', 1)->first())
                        {{ $user->teamMember->where('role', 1)->first()->user->name }}
                    @endif
                @endif
                @if ($user->hasRole('sales_manager'))
                    <h4 class="card-title">Equipo</h4>
                @endif
                <br>
                @if ($user->hasRole('seller') || $user->hasRole('sales_manager'))
                    <h4 class="card-title">Asistente</h4>
                @endif
                @if ($user->hasRole('sales_assistant'))
                    <h4 class="card-title">Vendedor</h4>
                    @foreach ($user->team->members as $member)
                        {{ $member->name }}
                    @endforeach
                @endif
                <br>
            </div>
        </div>
    </div>
@endsection
