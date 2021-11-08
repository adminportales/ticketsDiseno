@extends('layouts.app')

@section('title')
    <h3>Lista de Solicitudes </h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Información general acerca de las solicitudes</h4>
    </div>

    <div class="card-body">
        <table class="table" id="tableTickets">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Info</th>
                    <th>Solicitado por:</th>
                    <th>Asignado a:</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $designersRefactory = [];
                @endphp

                @foreach ($designers as $item)
                    @php
                        $designer = [
                            'name' => str_replace(' ', '#', $item->name),
                            'lastname' => str_replace(' ', '#', $item->lastname),
                            'id' => $item->id,
                        ];
                        array_push($designersRefactory, $designer);
                    @endphp
                @endforeach
                @foreach ($tickets as $ticket)
                    @php
                        $ticketInformation = $ticket->latestTicketInformation;
                    @endphp
                    <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticketInformation->title }}</td>
                        <td>
                            Tipo: {{ $ticket->typeTicket->type }}<br>
                            Prioridad: {{ $ticket->priorityTicket->priority }}<br>
                            Estado: {{ $ticket->latestStatusChangeTicket->status }}
                        </td>
                        <td>{{ $ticket->seller_name }}</td>
                        <td>
                            <change-designer-assigment designer="{{ $ticket->designer_name }}" :ticket={{ $ticket->id }}
                                :designers=@json($designersRefactory)></change-designer-assigment>
                        </td>
                        <td>
                            {{ $ticketInformation->created_at->diffForHumans() }}
                        </td>
                        <td><a href="{{ route('designer.show', ['ticket' => $ticket->id]) }}" class="boton-ver">Ver
                                ticket</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

    @section('styles')
        <link rel="stylesheet"
            href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/chartjs/Chart.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
        <style>
            table.dataTable td {
                padding: 15px 8px;
            }

            .fontawesome-icons .the-icon svg {
                font-size: 24px;
            }

        </style>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
        <script>
            // Jquery Datatable
            let jquery_datatable = $("#tableTickets").DataTable()

        </script>
    @endsection
