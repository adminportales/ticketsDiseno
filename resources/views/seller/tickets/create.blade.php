@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
        integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets\vendors\summernote\summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets\vendors\sweetalert2\sweetalert2.min.css') }}">
@endsection
@section('title')
    <h3>Crear Ticket</h3>
@endsection
@section('content')
    <div class="card-header">
        <h4 class="card-title">Ingresa la información necesaria para tu solicitud</h4>
    </div>
    <div class="card-body">
        @if (session('message'))
            <div class="alert alert-danger" role="alert" id="message">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('tickets.store') }}" method="post" class="mx-5" id="formCreate">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" placeholder="Nombre unico para tu solicitud" name="title"
                            value="{{ old('title') }}" />
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-md-5">
                    @role('sales_assistant')
                        @if (auth()->user()->team)
                            <div class="form-group">
                                <label for="type">Ejecutivo:</label>
                                <select name="executive" class="form-control">
                                    <option value="">Seleccione a quien corresponde la solicitud...</option>
                                    @foreach (auth()->user()->team->members as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == old('executive') ? 'selected' : '' }}>
                                            {{ $user->name . ' ' . $user->lastname }}</option>
                                    @endforeach
                                </select>
                                @error('executive')
                                    {{ $message }}
                                @enderror
                            </div>
                        @else
                            <div class="form-group">
                                <label for="type">Ejecutivo:</label>
                                <input type="text" class="form-control" disabled value="No tienes ejecutivos asignados">
                                @error('executive')
                                    {{ $message }}
                                @enderror
                            </div>
                        @endif
                    @endrole
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select name="type" class="form-control" id="type">
                            <option value="">Seleccione...</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ $type->id == old('type') ? 'selected' : '' }}>
                                    {{ $type->type }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group" id="customer">
                        <label for="customer">Cliente</label>
                        <input type="text" class="form-control" placeholder="Nombre del cliente" name="customer"
                            value="{{ old('customer') }}" />
                        @error('customer')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group" id="tecnica">
                        <label for="technique">Tecnica</label>
                        <select name="technique" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($techniques as $technique)
                                <option value="{{ $technique->id }}"
                                    {{ $technique->id == old('technique') ? 'selected' : '' }}>{{ $technique->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('technique')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group" id="companies">
                        @php
                            $companies = ['Promo Life', 'BH'];
                        @endphp
                        <label for="pantone">La presentacion es para:</label><br>
                        @foreach ($companies as $item)
                            @php
                                $check = false;
                                if (old('companies') != null) {
                                    foreach (old('companies') as $itemOld) {
                                        if ($item == $itemOld) {
                                            $check = true;
                                        }
                                    }
                                }
                            @endphp
                            <input class="form-check-input" type="checkbox" name="companies[]"
                                {{ $check ? 'checked' : '' }} value="{{ $item }}">
                            <label class="form-check-label" style="margin-right: 1rem" for="">
                                {{ $item }}
                            </label>
                        @endforeach
                    </div>
                    <div class="form-group" id="position">
                        <label for="pantone">Posicion del logo en el virtual</label>
                        <input type="input" class="form-control" placeholder="Ubicacion del logo en el producto"
                            name="position" value="{{ old('position') }}" />
                        @error('position')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group" id="pantone">
                        <label for="pantone">Pantone</label>
                        <input type="text" class="form-control" name="pantone" placeholder="Pantones separados por comas"
                            value="{{ old('pantone') }}" />
                        @error('pantone')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="form-group w-100" id="logoElement">
                        <label for="logo">Logo</label>
                        <div id="dropzoneLogo" class="dropzone form-control text-center" style="height: auto; width: auto">
                        </div>
                        <input type="hidden" name="logo" id="logo" value="{{ old('logo') }}">
                        @error('logo')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group w-100" id="productElement">
                        <label for="product">Producto</label>
                        <div id="dropzoneProduct" class="dropzone form-control text-center"
                            style="height: auto; width: auto"></div>
                        <input type="hidden" name="product" id="product" value="{{ old('product') }}">
                        @error('product')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group" id="itemsElement">
                        <label for="imagen">
                            Archivos necesarios para la solicitud:
                        </label>
                        <div id="dropzoneItems" class="dropzone form-control text-center" style="height: auto;"></div>
                        <input type="hidden" name="items" id="items" value="{{ old('items') }}">
                        @error('items')
                            <span class="block">{{ $message }}</span>
                        @enderror
                        <p id="error"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <p>En este espacio puedes informacion detallada de tu solicitud, agregar links, resaltar detalles, etc. </p>
                    <textarea id="summernote" name="description"></textarea>
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <input type="submit" value="Crear Ticket" class="boton">
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets\vendors\sweetalert2\sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets\vendors\summernote\summernote-lite.min.js') }}"></script>
    <script>
        $('#summernote').summernote({
            height: 300,
            minHeight: 200, // set minimum height of editor
            maxHeight: 500,
            toolbar: [
                // ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                // ['fontname', ['fontname']],
                ['insert', ['link']],
                ['color', ['color']],
                ['para', ['ul', 'ol']],
            ],
            fontNames: []
        });

        if (document.querySelector('#message')) {
            const message = document.querySelector('#message')
            setTimeout(() => {
                message.remove()
            }, 5000);
        }

        const selectType = document.querySelector('#type')
        const logoElement = document.querySelector('#logoElement')
        const itemsElement = document.querySelector('#itemsElement')
        const productElement = document.querySelector('#productElement')
        const pantoneElement = document.querySelector('#pantone')
        const tecnicaElement = document.querySelector('#tecnica')
        const clientElement = document.querySelector('#customer')
        const positionElement = document.querySelector('#position')
        const companiesElement = document.querySelector('#companies')

        let typeSelected = '{{ old('type') }}'
        formDynamic(typeSelected)
        selectType.addEventListener('change', () => {
            formDynamic(selectType.value)
        })

        function formDynamic(type) {
            switch (type) {
                case '1':
                    /*
                        Logo
                        Tecnica
                        Pantone
                        Producto
                        Posicion
                    */
                    companiesElement.classList.add('d-none')
                    logoElement.classList.remove('d-none')
                    clientElement.classList.remove('d-none')
                    productElement.classList.remove('d-none')
                    tecnicaElement.classList.remove('d-none')
                    pantoneElement.classList.remove('d-none')
                    itemsElement.classList.add('d-none')
                    positionElement.classList.remove('d-none')
                    break;
                case '2':
                    /*
                        Cliente
                        Items
                        Logo
                        Empresas
                    */
                    companiesElement.classList.remove('d-none')
                    positionElement.classList.add('d-none')
                    tecnicaElement.classList.add('d-none')
                    clientElement.classList.remove('d-none')
                    pantoneElement.classList.add('d-none')
                    logoElement.classList.remove('d-none')
                    productElement.classList.add('d-none')
                    itemsElement.classList.remove('d-none')
                    break;
                case '3':
                    logoElement.classList.add('d-none')
                    companiesElement.classList.add('d-none')
                    positionElement.classList.add('d-none')
                    productElement.classList.add('d-none')
                    itemsElement.classList.remove('d-none')
                    clientElement.classList.add('d-none')
                    tecnicaElement.classList.add('d-none')
                    pantoneElement.classList.add('d-none')
                    break;

                default:
                    break;
            }
        }
    </script>
@endsection
