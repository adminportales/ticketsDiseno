@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <div class="row">
            <div class="col-md-3 my-5">
                @include('seller.menu')
            </div>
            <div class="col-md-9">
                <h1>Bienvenido Tomas</h1>
                <h3>Inicio</h3>
                <h2>Tomas Vendedor</h2>
                <br>

                <div class="d-flex">
                    <div class="m-3"> Total de tickets:<b>10</b> </div>

                    <div class="m-3"> Total de tickets abiertos:<b>3</b></div>

                    <div class="m-3"> Total de tickets cerrados:<b>5</b></div>

                    <div class="m-3"> Total de tickets pendientes:<b>2</b></div>
                </div>



                <table>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Categoria de Ticket</th>
                        <th>Estatus</th>

                    </tr>

                    <tr>
                        <td>1</td>
                        <td>Presentacion Bimbo</td>
                        <td>Presentación</td>
                        <td>Nuevo</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Diseño especial Caribe Cooler</td>
                        <td>Diseño especial</td>
                        <td>En proceso</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Virtual Barcel</td>
                        <td>Virtual</td>
                        <td>En revisión</td>
                    </tr>

                </table>
            @endsection
