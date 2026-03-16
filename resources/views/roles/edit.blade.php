@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Rol</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" id="nombre" 
name="nombre" value="{{ old('nombre', $role->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" 
class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" 
name="descripcion" rows="3">{{ old('descripcion', $role->descripcion) 
}}</textarea>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="activo" 
name="activo" {{ old('activo', $role->activo) ? 'checked' : '' }}>
            <label class="form-check-label" for="activo">Activo</label>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('roles.index') }}" class="btn 
btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
