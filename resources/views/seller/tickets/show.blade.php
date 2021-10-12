@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Consultar ticket</h1>
        <h3>Consultar ticket</h3>
        <h2>Tomas Vendedor</h2>
        <ul>
            <li><a href="{{ route('inicio_vendedor') }}"></a></li>
            <li><a href="{{ route('crear_ticket') }}">Crear tickets</a></li>
            <li><a href="{{ route('consultar_ticket') }}">Consultar Ticket</a></li>
        </ul>
    </div>
@endsection
