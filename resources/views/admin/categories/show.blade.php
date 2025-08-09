@extends('layouts.app')

@section('content_header')
    <h1>Ver Categoría <strong>{{ $category->name }}</strong></h1>
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Estado</th>
                                    <td>
                                        @switch($category->status)
                                            @case(0)
                                                Inactivo
                                            @break

                                            @case(1)
                                                Activo
                                            @break

                                            @default
                                                Activo
                                        @endswitch
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('categories.index') }}" class="btn btn-info">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
