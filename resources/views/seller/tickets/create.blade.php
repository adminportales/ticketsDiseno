@extends('layouts.app')

@section('content')
    <div style="width: 980px; text-align: center; margin: auto; border: 2px solid gray;">
        <div class="row">
            <div class="col-md-3 my-5">
                @include('seller.menu')
            </div>
            <div class="col-md-9">
                <h1>Crear ticket</h1>
                <h2>Tomas Vendedor</h2>

                <form action="{{ route('tickets.store') }}" method="post" enctype="multipart/form-data"
                    class="mx-5">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Categoria</label>
                                <select name="category" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                {{$message}}
                            @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer">Cliente</label>
                                <input type="text" class="form-control" name="customer" />
                                @error('customer')
                                {{$message}}
                            @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Titulo</label>
                                <input type="text" class="form-control" name="title" />
                                @error('title')
                                {{$message}}
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="technique">Tecnica</label>
                                <input type="text" class="form-control" name="technique" />
                                @error('technique')
                                {{$message}}
                            @enderror
                            </div>
                            <div class="form-group">
                                <label for="pantone">Pantone</label>
                                <input type="color" class="form-control" name="pantone" />
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo" />
                                @error('logo')
                                {{$message}}
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <textarea rows="" cols="" class="form-control w-100" name="description"></textarea>
                                @error('description')
                                {{$message}}
                            @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product">Producto</label>
                            <input type="file" class="form-control" name="product" />
                            @error('product')
                            {{$message}}
                        @enderror
                        </div>


                        <p>Dropzone para los items</p>
                    </div>
                    <input type="submit" value="Crear Ticket" class="btn btn-success">
                </form>
            </div>
        </div>
    @endsection
