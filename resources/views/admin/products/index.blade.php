@extends('layouts.app')
@section('content_header')
    <h1>Productos</h1>
@stop
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        @can('admin.create')
                            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Crear Producto</a>
                        @endcan
                        <table id="products-table" class="table table-bordered table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Subcategoría(s)</th>
                                    <th class="text-center">Estado</th>
                                    @can('admin.edit')
                                        <th>Acciones</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        @php
                                            $arrSubcategories = [];
                                            foreach ($product_subcategories as $product_subcategory) {
                                                if ($product_subcategory->product_id == $product->id) {
                                                    $arrSubcategories[] = $subcategories
                                                        ->where('id', $product_subcategory->subcategory_id)
                                                        ->first()->name;
                                                }
                                            }
                                            if (count($arrSubcategories) > 0) {
                                                $arrSubcategories = implode(', ', $arrSubcategories);
                                            } else {
                                                $arrSubcategories = 'Sin subcategorías';
                                            }
                                        @endphp
                                        <td>{{ $arrSubcategories }}</td>
                                        <td>
                                            @switch($product->status)
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
                                        @can('admin.edit')
                                            <td>
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="btn btn-primary">Editar</a>
                                                {{-- Boton de eliminar con evento click que muestre un modal para confirmar si quiere eliminar el producto --}}
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $product->id }}">Eliminar</button>

                                                {{-- Modal para confirmar la eliminación del producto --}}
                                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Producto
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Está seguro de eliminar el producto
                                                                <strong>{{ $product->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form action="{{ route('products.destroy', $product) }}"
                                                                    method="post" style="display: inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/responsive.dataTables.js"></script>
    <script>
        $('#products-table').DataTable({
            responsive: true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/2.0.2/i18n/es-ES.json"
            },
            "order": [
                [0, 'desc']
            ],
            columnDefs: [{
                responsivePriority: 1,
                targets: -1
            }]
        });
    </script>
@endsection
