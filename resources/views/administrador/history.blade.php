{{-- Crear el cocumento con el layout --}}
@extends('layouts.app')
@section('content')
    <div class="p-4">
        {{-- Crear la tabla para la variable history --}}
        <table class="table table-bordered">
            {{-- Crear el encabezado de la tabla --}}
            <thead>
                {{-- Crear la fila de la tabla --}}
                <tr>
                    {{-- Crear la columna de la tabla --}}
                    <th scope="col">Usuario</th>
                    {{-- Crear la columna de la tabla --}}
                    <th scope="col">Acción</th>
                    {{-- Crear la columna de la tabla --}}
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            {{-- Crear el cuerpo de la tabla --}}
            <tbody>
                {{-- Recorrer la variable history --}}
                @foreach ($history as $item)
                    {{-- Crear la fila de la tabla --}}
                    <tr>
                        {{-- Crear la columna de la tabla --}}
                        <td>{{ $item->user->name }}</td>
                        {{-- Crear la columna de la tabla --}}
                        <td>{{ $item->info }}</td>
                        {{-- Crear la columna de la tabla --}}
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $history->links() }}
    </div>
@endsection
