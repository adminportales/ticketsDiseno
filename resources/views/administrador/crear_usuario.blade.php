@extends('layouts.app')

@section('content')

    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <h1>Crear nuevo usuario</h1>
        <h3>Ver usuario</h3>
        <h2>Samuel Administrador</h2>
        @include('administrador.menu')


        <form action="">
            <p>Nombre: <input type="text" name="nombre" size="40" required></p>
            <p>Apellidos: <input type="text" name="apellidos" size="40" required></p>
            <p>Email: <input type="email" name="email" size="40" required></p>
            <p>Contraseña: <input type="password" size="40"></p>
            <p>Confirmar contraseña: <input type="password" size="40" required></p>
            <p>
                <input type="submit" id="boton_crear" value="Crear nuevo usuario">
                <input type="reset" value="Cancelar">
            </p>

        </form>

        <script>
            const boton_crear = document.querySelector("#boton_crear");
            boton_crear.addEventListener('click', () => {
                confirm("¿Estas seguro de realizar cambios?")
            })
        </script>


@endsection
