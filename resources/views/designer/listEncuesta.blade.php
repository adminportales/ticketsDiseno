@extends('layouts.app')

@section('title')
@endsection

@section('content')
    <div class="card-header">
        <p> Lista especifica de ncuestas</p>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Diseñador</th>
                    <th>Ticket</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($info as $data)
                    <tr>
                        <td>
                            {{ $data['diseñador'] }}
                        </td>
                        <td>{{ $data['ticket_id'] }}</td>
                        <td>{{ $data['pregunta'] }}</td>
                        <td>{{ $data['respuesta'] }}</td>
                        <td>{{ $data['comentario'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2\sweetalert2.all.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
