@extends('layouts.app')

@section('content')

    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <h1>Editar usuario</h1>
        <h3>Asignar permisos</h3>
        <h2>Samuel Administrador</h2>
        @include('administrador.menu')

        <form action="">
            <p>Nombre: <input type="text" name="nombre" size="40" required></p>

            <p>

                <b> Roles</b><br>

                <input type="radio" name="boton" value="1"> Administrador<br>
                <input type="radio" name="boton" value="2"> Diseñador<br>
                <input type="radio" name="boton" value="3"> Vendedor<br>
                <input type="radio" name="boton" value="4"> Gerente de ventas<br>
                <input type="radio" name="boton" value="5"> Gerente de diseño<br>
                <br>

                <b> Permisos</b><br>

                <input type="checkbox" name="permiso" value="1">Lectura
                <br>
                <input type="checkbox" name="permiso" value="2">Escritura
                <br>
                <input type="checkbox" name="permiso" value="3">Ejecución
                <br>
                <input type="checkbox" name="permiso" value="4">Creación
                <br>
                <input type="checkbox" name="permiso" value="5">Borrado



            </p>

        </form>


    @endsection
