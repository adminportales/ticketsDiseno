@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
        integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropzoneItems {
            height: 400px;
        }

    </style>
@endsection

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
                                <label for="type">Tipo</label>
                                <select name="type" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer">Cliente</label>
                                <input type="text" class="form-control" name="customer" />
                                @error('customer')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Titulo</label>
                                <input type="text" class="form-control" name="title" />
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="technique">Tecnica</label>
                                <input type="text" class="form-control" name="technique" />
                                @error('technique')
                                    {{ $message }}
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
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="product">Producto</label>
                                <input type="file" class="form-control" name="product" />
                                @error('product')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <textarea rows="" cols="" class="form-control w-100" name="description"></textarea>
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="imagen">
                                    Items del Producto:
                                </label>
                                <div id="dropzoneItems" class="dropzone form-control" style="height: auto;"></div>
                                <input type="hidden" name="imagen" id="imagen" value="{{ old('imagen') }}">
                                @error('imagen')
                                    <span class="block">{{ $message }}</span>
                                @enderror
                                <p id="error"></p>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Crear Ticket" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"
        integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        Dropzone.autoDiscover = false;
        document.addEventListener('DOMContentLoaded', () => {
            // Dropzone
            const dropzoneDevJobs = new Dropzone('#dropzoneItems', {
                url: "/tickets/items",
                dictDefaultMessage: 'Arrastra aqui tu archivo',
                acceptedFiles: '.png,.jpg,.jpeg,.gif,.bmp',
                addRemoveLinks: true,
                dictRemoveFile: 'Borrar Archivo',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                init: function() {
                    if (document.querySelector('#imagen').value.trim()) {
                        let imagenPublicada = {}
                        imagenPublicada.size = 3000;
                        imagenPublicada.name = document.querySelector('#imagen').value

                        this.options.addedfile.call(this, imagenPublicada)
                        this.options.thumbnail.call(this, imagenPublicada,
                            `/storage/vacantes/${imagenPublicada.name}`)

                        imagenPublicada.previewElement.classList.add('dz-success')
                        imagenPublicada.previewElement.classList.add('complete')
                    } else {
                        console.log("No hay nada");
                    }
                },
                success: function(file, response) {
                    console.log(file);
                    console.log(response.correcto);
                    document.querySelector('#error').textContent = ''
                    document.querySelector('#imagen').value += response.correcto
                    // Add al objeto de archivo, el nombre de la imagen en el servidor
                    file.nombreServidor = response.correcto
                    // file.previewElement.parentNode.removeChild(file.previewElement)
                },
                error: function(file, response) {
                    // console.log(response);
                    // console.log(file);
                    document.querySelector('#error').textContent = 'Formato no valido'
                },
                maxfilesexceeded: function(file) {
                    if (this.files[1] != null) {
                        this.removeFile(this.files[0]);
                        this.addFile(file);
                    }
                    // console.log(this.files);
                },
                removedfile: function(file, response) {
                    file.previewElement.parentNode.removeChild(file.previewElement)
                    // console.log(file);
                    console.log('El archivo borrado fue');
                    params = {
                        imagen: file.nombreServidor
                    }
                    // console.log(params);
                    axios.post('/tickets/deleteItem', params)
                        .then(response => console.log(response))
                }
            });
        })
    </script>
@endsection
