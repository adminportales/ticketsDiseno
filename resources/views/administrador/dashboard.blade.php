@extends('layouts.app')

@section('title')
    <h3>Bienvenido {{ auth()->user()->name . ' ' . auth()->user()->lastname }}</h3>
@endsection

@section('dashboard')
    <div class="card">
        <div class="card-body">
            <section class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Usuarios activos</h6>
                                            <h6 class="font-extrabold mb-0">{{ $user }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Tickets Creados</h6>
                                            <h6 class="font-extrabold mb-0">{{ count($tickets) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">Filtro por Fechas</h6>
                                            <h6 class="font-extrabold mb-0">Pendiente</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="text-center">Tipos de Tickets Creados</p>
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
                <div class="col-md-8">
                    <p class="text-center">Usuarios Creadores de Tickets</p>
                    <canvas id="myChartBarCreated" width="400" height="200"></canvas>
                </div>
                <div class="w-100">
                    <br>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-center">Recepcion de Tickets</p>
                            <canvas id="chartDesigner" width="400" height="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <p class="text-center">Estado de Tickets Creados</p>
                            <canvas id="chartStatus" width="400" height="400"></canvas>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <p class="text-center">Historial de Entregas al dia</p>
                            <canvas id="chartDeliveries" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="text-center">Usuarios que no han creado un ticket</p>
                    <table class="table">
                        <tbody>
                            @foreach ($dataUserInfoTickets[2] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- {{ $dataTypeTickets }} --}}
            </section>
        </div>

    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()

        // Chart Type
        const ctxType = 'myChart';
        const dataType = {
            labels: [
                'Virtual',
                'Presentacion',
                'Diseños Especiales'
            ],
            datasets: [{
                label: 'Tipos de Tickets Creados',
                data: @json($dataTypeTickets),
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        const myChartType = new Chart(ctxType, {
            type: 'pie',
            data: dataType,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart Creadores
        const ctx = 'myChartBarCreated';
        // $dataUserInfoTickets = [$dataUserCreatedTickets, $dataUserCountTickets];
        const labels = @json($dataUserInfoTickets[0]);
        const data = {
            labels: labels,
            datasets: [{
                label: 'Total de Tickets',
                data: @json($dataUserInfoTickets[1]),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        };
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });

        // Chart Type
        const ctxDesigner = 'chartDesigner';
        const dataDesigner = {
            labels: @json($dataUserInfoTicketsDesign[0]),
            datasets: [{
                label: 'Tipos de Tickets Creados',
                data: @json($dataUserInfoTicketsDesign[1]),
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        const myChartDesigner = new Chart(ctxDesigner, {
            type: 'pie',
            data: dataDesigner,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        // Chart Type
        const ctxStatus = 'chartStatus';
        const dataStatus = {
            labels: @json($dataInfoStatus[0]),
            datasets: [{
                label: 'Tipos de Tickets Creados',
                data: @json($dataInfoStatus[1]),
                backgroundColor: [
                    'rgb(155, 99, 232)',
                    'rgb(4, 162, 23)',
                    'rgb(54, 12, 235)',
                    'rgb(255, 25, 86)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        const myChartStatus = new Chart(ctxStatus, {
            type: 'pie',
            data: dataStatus,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const chartDeliveries = document.getElementById('chartDeliveries');

        const dataDeliveriesBackend = @json($dataDeliveries);
        const etiquetas = dataDeliveriesBackend[0]
        console.log(dataDeliveriesBackend);

        const dataDeliveries = {
            labels: etiquetas,
            datasets: [{
                    label: dataDeliveriesBackend[1][0].name,
                    data:  dataDeliveriesBackend[1][0].data, // Valores de ejemplo para Dataset 1
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                },
                {
                    label: dataDeliveriesBackend[1][1].name,
                    data: dataDeliveriesBackend[1][1].data, // Valores de ejemplo para Dataset 2
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                },
                {
                    label: dataDeliveriesBackend[1][2].name,
                    data: dataDeliveriesBackend[1][2].data, // Valores de ejemplo para Dataset 2
                    borderColor: 'rgb(255, 205, 86)',
                    backgroundColor: 'rgba(255, 205, 86, 0.5)',
                },
            ]
        };
        const myChartDeliveries = new Chart(chartDeliveries, {
            type: 'line',
            data: dataDeliveries,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            },
        })
    </script>
@endsection
