@extends('layouts.app')

@section('title')
    <h3>Lista de Tickets en Espera</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Lista de Tickets en Espera</h4>
    </div>

    @livewire('list-tickets.wait-list-ticket-component')
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2\sweetalert2.all.min.js') }}"></script>
@endsection
