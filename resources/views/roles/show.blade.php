@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del Rol</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $role->nombre }}</h5>
            
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $role->id }}</td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $role->nombre }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td>{{ $role->descripcion ?? 'Sin descripción' }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>
                        @if($role->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Fecha de Creación</th>
                    <td>{{ $role->created_at }}</td>
                </tr>
                <tr>
                    <th>Última Actualización</th>
                    <td>{{ $role->updated_at }}</td>
                </tr>
            </table>

            <a href="{{ route('roles.index') }}" class="btn 
btn-secondary">Volver</a>
            <a href="{{ route('roles.edit', $role) }}" class="btn 
btn-warning">Editar</a>
        </div>
    </div>
</div>
@endsection
