@extends('layouts.app')

@section('title')
    <h3>Lista de Tickets Asignados</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general acerca de las solicitudes que tienes asignadas</h4>
    </div>

    @livewire('list-tickets.list-tickets-designer-component')
@endsection

