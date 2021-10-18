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
@section('title')
    <h3>Editar Ticket</h3>
@endsection
@section('content')
    <div class="card-header">
        <h4 class="card-title">Edita la información necesaria de tu solicitud</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('tickets.update', ['ticket' => $ticket->id]) }}" method="post"
            enctype="multipart/form-data" class="mx-5">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" name="title" value="{{ $ticketInformation->title }}" />
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select name="type" class="form-control" disabled>
                            <option value="">Seleccione...</option>
                            @foreach ($types as $type)
                                <option {{ $type->id == $ticket->type_id ? 'selected' : '' }} value="{{ $type->id }}">
                                    {{ $type->type }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customer">Cliente</label>
                        <input type="text" class="form-control" name="customer"
                            value="{{ $ticketInformation->customer }}" />
                        @error('customer')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="technique">Tecnica</label>
                        <input type="text" class="form-control" name="technique"
                            value="{{ $ticketInformation->technique }}" />
                        @error('technique')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pantone">Pantone</label>
                        <input type="color" class="form-control" name="pantone"
                            value="{{ $ticketInformation->pantone }}" />
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <textarea rows="" cols="" class="form-control w-100"
                            name="description">{{ $ticketInformation->description }}</textarea>
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control" name="logo" value="{{ $ticketInformation->logo }}" />
                        @error('logo')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product">Producto</label>
                        <input type="file" class="form-control" name="product"
                            value="{{ $ticketInformation->product }}" />
                        @error('product')
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
            <input type="submit" value="Editar Ticket" class="btn btn-warning">
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"
        integrity="sha512-oQq8uth41D+gIH/NJvSJvVB85MFk1eWpMK6glnkg6I7EdMqC1XVkW7RxLheXwmFdG03qScCM7gKS/Cx3FYt7Tg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let items = new Set()
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
                    const itemsOld = document.querySelector('#imagen').value.split(',')
                    if (document.querySelector('#imagen').value.trim()) {
                        console.log(itemsOld);
                        let imagenPublicada = []
                        itemsOld.forEach((itemOld, index) => {
                            items.add(itemOld)
                            imagenPublicada[index] = {}
                            imagenPublicada[index].size = 1024;
                            imagenPublicada[index].name = itemOld

                            this.options.addedfile.call(this, imagenPublicada[index])
                            this.options.thumbnail.call(this, imagenPublicada[index],
                                `/storage/items/${imagenPublicada[index].name}`)
                            imagenPublicada[index].previewElement.classList.add('dz-success')
                            imagenPublicada[index].nombreServidor = itemOld
                            //imagenPublicada[index].previewElement.classList.add('complete')
                            imagenPublicada[index].previewElement.children[2].classList.add(
                                'd-none')
                            imagenPublicada[index].previewElement.children[0].children[0]
                                .classList.add('w-100')
                        });
                    }
                },
                success: function(file, response) {
                    console.log(file);
                    console.log(response);
                    document.querySelector('#error').textContent = ''
                    items.add(response.correcto)
                    console.log(items);
                    document.querySelector("#imagen").value = [...items];
                    // Add al objeto de archivo, el nombre de la imagen en el servidor
                    file.nombreServidor = response.correcto
                    // file.previewElement.parentNode.removeChild(file.previewElement)
                },
                error: function(file, response) {
                    // console.log(response);
                    // console.log(file);
                    document.querySelector('#error').textContent = 'Formato no valido'
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
                        .then(response => {
                            console.log(response.data);
                            if (items.has(response.data.imagen)) {
                                items.delete(response.data.imagen)
                                document.querySelector("#imagen").value = [...items];
                            }
                            console.log(items);
                        })
                }
            });
        })
    </script>
@endsection
