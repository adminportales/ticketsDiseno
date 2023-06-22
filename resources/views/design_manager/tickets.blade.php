@extends('layouts.app')

@section('title')
    <h3>Mis tickets</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general acerca de las solicitudes</h4>
    </div>
    @livewire('list-tickets.list-tickets-designer-component')
@endsection
