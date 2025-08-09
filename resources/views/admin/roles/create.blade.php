@extends('layouts.app')

@section('content_header')
    <h1>Crear Rol</h1>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" placeholder="Nombre del rol"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            {{-- Lista de permisos --}}
                            <div class="form-group row">
                                <label for="permissions"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Permisos') }}</label>
                                <div class="col-md-6">
                                    @foreach ($permissions as $permission)
                                        <div>
                                            <label>
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                                                {{ $permission->description }}
                                            </label>
                                        </div>
                                    @endforeach

                                    @error('permissions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Crear') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('roles.index') }}" class="btn btn-info">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
