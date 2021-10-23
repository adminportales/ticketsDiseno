@extends('layouts.app')

@section('title')
    <h3>Editar asignaciones</h3>
@endsection

@section('content')
    <div class="card-header">
        <h4 class="card-title">Modificar los tipos de ticktes que recibe {{ $user->name . ' ' . $user->lastname }} por
            defecto</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('ticketAssigment.update', ['user' => $user->id]) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="d-flex justify-content-between">
                        @foreach ($types as $type)
                            @php $check = false; @endphp
                            @foreach ($userTypes as $userType)
                                @if ($type->id == $userType->id)
                                    @php $check = true; @endphp
                                @break
                            @endif
                        @endforeach
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="types[]" id="check"
                                {{ $check ? 'checked' : '' }} value="{{ $type->id }}">
                            <label class="form-check-label" for="check">
                                {{ $type->type }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <br>
                    <input type="submit" value="Guardar cambios" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/all.min.css') }}">
    <style>
        table.dataTable td {
            padding: 15px 8px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#tableTickets").DataTable()
    </script>
@endsection
