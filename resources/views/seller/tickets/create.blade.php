@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
        integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets\vendors\sweetalert2\sweetalert2.min.css
        ') }}">
@endsection
@section('title')
    <h3>Crear Ticket</h3>
@endsection
@section('content')
    <div class="card-header">
        <h4 class="card-title">Ingresa la información necesaria para tu solicitud</h4>
    </div>
    <div class="card-body">

        <form action="{{ route('tickets.store') }}" method="post" enctype="multipart/form-data" class="mx-5">
            <div class="row">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" />
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select name="type" class="form-control">
                            <option value="">Seleccione...</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customer">Cliente</label>
                        <input type="text" class="form-control" name="customer" value="{{ old('customer') }}" />
                        @error('customer')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="technique">Tecnica</label>
                        <input type="text" class="form-control" name="technique" value="{{ old('technique') }}" />
                        @error('technique')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pantone">Pantone</label>
                        <input type="color" class="form-control" name="pantone" value="{{ old('pantone') }}" />
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <textarea rows="" cols="" class="form-control w-100"
                            name="description">{{ old('description') }}</textarea>
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="d-flex">
                        <div class="form-group w-50">
                            <label for="logo">Logo</label>
                            <div id="dropzoneLogo" class="dropzone form-control text-center"
                                style="height: auto; width: auto"></div>
                            <input type="hidden" name="logo" id="logo" value="{{ old('logo') }}">
                            @error('logo')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="form-group w-50">
                            <label for="product">Producto</label>
                            <div id="dropzoneProduct" class="dropzone form-control text-center"
                                style="height: auto; width: auto"></div>
                            <input type="hidden" name="product" id="product" value="{{ old('product') }}">
                            @error('product')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imagen">
                            Items del Producto:
                        </label>
                        <div id="dropzoneItems" class="dropzone form-control text-center" style="height: auto;"></div>
                        <input type="hidden" name="items" id="items" value="{{ old('items') }}">
                        @error('items')
                            <span class="block">{{ $message }}</span>
                        @enderror
                        <p id="error"></p>
                    </div>
                </div>
            </div>
            <input type="submit" value="Crear Ticket" class="btn btn-success">
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"
        integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets\vendors\sweetalert2\sweetalert2.all.min.js') }}"></script>
@endsection
