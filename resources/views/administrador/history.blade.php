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
                    <th scope="col">Acción</th>
                    <th scope="col">Descripcion</th>
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
                        <td style="vertical-align: middle">
                            @php
                                $color = '';
                                switch ($item->action) {
                                    case 'disponibilidad':
                                        $color = 'danger';
                                        break;
                                    case 'reasignacion':
                                        $color = 'warning';
                                        break;
                                    case 'configuracion':
                                        $color = 'info';
                                        break;
                                    case 'creacion':
                                        $color = 'primary';
                                        break;

                                    default:
                                        # code...
                                        break;
                                }
                            @endphp
                            <div class="alert alert-{{ $color }} p-0 text-center p-1 capitalize">
                                {{ Str::ucfirst($item->action) }}</div>
                        </td>
                        <td>{!! $item->info !!}</td>

                        @php

                            // Obtener la fecha actual
                            $ahora = now();

                            // Calcular la diferencia en días entre la fecha dada y la fecha actual
                            $diferencia = $ahora->diffInDays($item->created_at, false);

                            // Formatear la fecha según los diferentes casos
                            if ($diferencia == 0) {
                                // Hoy
                                $formato = 'H:i.A';
                                $resultado = 'hoy a las ' . $item->created_at->format($formato);
                            } elseif ($diferencia == 1) {
                                // Ayer
                                $formato = 'H:i A';
                                $resultado = 'ayer a las ' . $item->created_at->format($formato);
                            } else {
                                // Otra fecha
                                if ($ahora->year == $item->created_at->year) {
                                    $formato = 'd-m';
                                } else {
                                    $formato = 'd-m-y';
                                }
                                $resultado = $item->created_at->format($formato) . ' a las ' . $item->created_at->format('H:i A');
                            }
                        @endphp
                        {{-- Crear la columna de la tabla --}}
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $history->links() }}
    </div>
@endsection
