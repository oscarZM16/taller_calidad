@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Listado de Insumos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('insumos.create') }}" class="btn btn-primary mb-3">+ Agregar Insumo</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($insumos as $insumo)
                    <tr>
                        <td>{{ $insumo->id }}</td>
                        <td>{{ $insumo->nombre }}</td>
                        <td>{{ $insumo->descripcion }}</td>
                        <td>{{ $insumo->cantidad }}</td>
                        <td>{{ $insumo->estado }}</td>
                        <td>
                            <a href="{{ route('insumos.edit', $insumo) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('insumos.destroy', $insumo) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este insumo?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay insumos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection