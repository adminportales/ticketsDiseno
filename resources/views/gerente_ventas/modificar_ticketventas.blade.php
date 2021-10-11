@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Crear ticket</h1>
        <h3>Crear ticket</h3>
        <h2>Aide Gerente de Ventas</h2>
        <ul>
            <li><a href="{{ route('inicio_gerenteventas') }}">Inicio</a></li>
            <li><a href="{{ route('crear_ticketventas') }}">Crear ticket</a></li>
            <li><a href="{{ route('consultar_ticketventas') }}">Consultar ticket</a></li>
            <li><a href="{{ route('asignar_prioridades') }}">Asignar prioridades</a></li>
        </ul>
        <br>
        <form enctype="multipart/form-data">
            <option>Virtual
            </option>

            <p>Cliente: <input type="text" name="cliente" size="40"></p>
            <p>Titulo: <input type="text" name="titulo" size="40"></p>
            <p>Técnica: <input type="text" name="técnica" size="40"></p>
            <p>Pantone: <input type="color"></p>
            <p>Logo: <input type="file" name="subirarchivos"></p>
            <p>Descripción: <input type="text" name="descripcion" size="100"></p>
            <p>
                <input type="submit" value="Crear">
                <input type="reset" value="Borrar">
            </p>
        </form>
        <br>

        <form enctype="multipart/form-data">
            <option>Presentación
            </option>

            <p>Cliente: <input type="text" name="cliente" size="40"></p>
            <p>Titulo: <input type="text" name="titulo" size="40"></p>
            <p>Items del producto: <input type="file" name="item"></p>
            <p>Logo: <input type="file" name="logo"></p>
            <p>Descripción: <input type="text" name="descripcion" size="100"></p>
            <p>
                <input type="submit" value="Crear">
                <input type="reset" value="Borrar">
            </p>
        </form>
        <br>

        <form enctype="multipart/form-data">
            <option>Diseño
            </option>

            <p>Cliente: <input type="text" name="cliente" size="40"></p>
            <p>Titulo: <input type="text" name="titulo" size="40"></p>
            <p>Logo: <input type="file" name="item"></p>
            <p>Archivo: <input type="file" name="logo"></p>
            <p>Descripción: <input type="text" name="descripcion" size="100"></p>
            <p>
                <input type="submit" value="Crear">
                <input type="reset" value="Borrar">
            </p>
        </form>
    </div>
@endsection
