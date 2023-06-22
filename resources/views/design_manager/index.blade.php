@extends('layouts.app')

@section('title')
    <h3>Lista de Solicitudes </h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general acerca de las solicitudes</h4>
    </div>

    @livewire('list-tickets.list-tickets-designer-manager-component')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
@endsection
