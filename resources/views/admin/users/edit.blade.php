@extends('layouts.app')

@section('content_header')
    <h1>Asignar Rol a <strong>{{ $user->name }}</strong></h1>
@endsection

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
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            {{-- Bucle para renderizar cada rol como un checkbox --}}
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    {{-- El 'name' debe ser 'roles[]' para enviar un array de IDs --}}
                                    <input class="form-check-input" type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}" 
                                        {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach

                            {{-- Estado --}}
                            
                            <div class="form-group row">
                                <label for="status"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                                <div class="col-md-6">
                                    <select id="status" class="form-control @error('status') is-invalid @enderror"
                                        name="status">
                                        <option value="{{ true }}" {{ $user->status ? 'selected' : '' }}>Activo</option>
                                        <option value="{{ 0 }}" {{ !$user->status ? 'selected' : '' }}>Inactivo</option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mt-3">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Asignar Roles') }}
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-info">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection