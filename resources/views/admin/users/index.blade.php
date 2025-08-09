@extends('layouts.app')

@section('content_header')
    <h1>Usuarios</h1>
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        {{-- <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Crear Usuario</a> --}}
                        <table id="users-table" class="table table-bordered table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th> 
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->status ? 'Activo' : 'Inactivo' }}</td>
                                        <td>
                                            {{-- <a href="{{ route('users.show', $user) }}"
                                                class="btn btn-primary">Ver</a> --}}
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="btn btn-primary">Editar</a>
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
        $('#users-table').DataTable({
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