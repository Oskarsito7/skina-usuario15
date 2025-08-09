@extends('layouts.app')

@section('content_header')
    <h1>Roles</h1>
@stop
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
                <div class="card">
                    <div class="card-body">
                        @can('admin.create')
                            <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Crear Role</a>
                        @endcan
                        <table id="roles-table" class="table table-bordered table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('admin.edit')
                                                <a href="{{ route('roles.edit', $role) }}"
                                                    class="btn btn-primary">Editar</a>
                                            @endcan
                                            @can('admin.destroy')
                                                {{-- Boton de eliminar con evento click que muestre un modal para confirmar si quiere eliminar el role --}}
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $role->id }}">Eliminar</button>
                                                {{-- Modal para confirmar la eliminación del role --}}
                                                <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Eliminar
                                                                    Role</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Está seguro de eliminar el role
                                                                <strong>{{ $role->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancelar</button>
                                                                <form action="{{ route('roles.destroy', $role) }}"
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
        $('#roles-table').DataTable({
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