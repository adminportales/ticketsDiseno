@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid rgb(29, 123, 151);">
        <h1>Crear ticket</h1>
        <h3>Crear ticket</h3>
        <h2>Tomas Vendedor</h2>
        <ul>
            <li><a href="{{ route('inicio_vendedor')}}"></a></li>
            <li><a href="{{ route('crear_ticket') }}">Crear tickets</a></li>
            <li><a href="{{ route('consultar_ticket') }}">Consultar Ticket</a></li>

            <br>

            <form enctype="multipart/form-data">
                <select name="categoria1">
                    <option>Virtual
                    </option>
                </select>

                <p>Cliente: <input type="text" name="cliente" size="40"></p>
                <p>Titulo: <input type="text" name="titulo" size="40"></p>
                <p>Técnica: <input type="text" name="técnica" size="40"></p>
                <p>Pantone: <input type="color"></p>
                <p>Items del producto: <input type="file" name="subir_archivo"></p>
                <p>Logo: <input type="file" name="logo"></p>

                <p>Descripción: <input type="text" name="descripcion" size="100"></p>
                <p>
                    <input type="submit" value="Crear">
                    <input type="reset" value="Borrar">
                </p>
            </form>
            <br>

            <form enctype="multipart/form-data">
                <select name="categoria2">
                    <option>Presentación
                    </option>
                </select>

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
                <select name="categoria3">
                    <option>Diseño
                    </option>
                </select>

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


@endsection
