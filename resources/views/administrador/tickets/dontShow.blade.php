@extends('layouts.app')
@section('title')
    <h3></h3>
@endsection
@section('content')
    <div class="card-header">
        <div class="d-flex justify-content-center">
            <h4 class="card-title">Ooops!, aun no se puede visualizar este tipo de archivos</h4>
        </div>
    </div>
    <div class="card-body text-center">
        <h6>No te preocupes, esto tiene solucion</h6>
        <p class="font-bold">Notifica al area de desarrollo que quieres una vista previa de los archivos con extension <span
                class="text-danger">.{{ $extension }}</span></p>
    </div>
@endsection
