@extends('layouts.app')

@section('title')
    <h3>Encuestas</h3>
@endsection

@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="card-title">Información general de la encuesta</h4>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Diseñador</th>
                    <th>Tickets</th>
                    <th>Malas</th>
                    <th>Neutrales</th>
                    <th>Buenas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($info as $data)
                    <tr>
                        <td>
                            <a
                                href="{{ route('designer.listEncuesta', ['designer' => $data['diseñador']]) }}">{{ $data['diseñador'] }}</a>
                        </td>
                        <td>{{ $data['tickets'] }}</td>
                        <td>{{ $data['mal'] }}</td>
                        <td>{{ $data['neutral'] }}</td>
                        <td>{{ $data['buena'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
