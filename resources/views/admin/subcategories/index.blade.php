@extends('layouts.app')

@section('content_header')
    <h1>Subcategorías</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        @can('admin.create')
                            <a href="{{ route('subcategories.create') }}" class="btn btn-primary mb-3">Crear Subcategoría</a>
                        @endcan
                        <table id="subcategories-table" class="table table-bordered table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Categoría</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcategories as $subcategory)
                                    <tr>
                                        <td>{{ $subcategory->id }}</td>
                                        <td>{{ $subcategory->name }}</td>
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
                                        <td>{{ $categories->where('id', $subcategory->category_id)->first()->name }}</td>
                                        <td>
                                            @can('admin.show')
                                                <a href="{{ route('subcategories.show', $subcategory) }}"
                                                    class="btn btn-primary">Ver</a>
                                            @endcan
                                            @can('admin.edit')
                                                <a href="{{ route('subcategories.edit', $subcategory) }}"
                                                    class="btn btn-primary">Editar</a>
                                            @endcan
                                            @can('admin.destroy')
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $subcategory->id }}">Eliminar</button>
                                                <div class="modal fade" id="deleteModal{{ $subcategory->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Eliminar
                                                                    Subcategoría</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Está seguro de eliminar la subcategoría
                                                                <strong>{{ $subcategory->name }}</strong>, incluyendo productos
                                                                ?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form
                                                                    action="{{ route('subcategories.destroy', $subcategory) }}"
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
                                            @endcan
                                        </td>
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
        $('#subcategories-table').DataTable({
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
