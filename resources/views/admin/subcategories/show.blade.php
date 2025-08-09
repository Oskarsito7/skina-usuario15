@extends('layouts.app')

@section('content_header')
    <h1>Ver Subcategoría <strong>{{ $subcategory->name }}</strong></h1>
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
                                    <td>{{ $subcategory->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre</th>
                                    <td>{{ $subcategory->name }}</td>
                                </tr>
                                <tr>
                                    <th>Estado</th>
                                    <td>
                                        @switch($subcategory->status)
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
                                <tr>
                                    <th>Categoría</th>
                                    <td>{{ $categories->where('id', $subcategory->category_id)->first()->name }}</td>
                                </tr>
                                <tr>
                                    <th>Productos</th>
                                    <td>
                                        @foreach ($products as $product)
                                            <p>{{ $product->name }}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('subcategories.index') }}" class="btn btn-info">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection